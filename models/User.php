<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\models\form\export\ExportForm;
use app\models\form\user\MySettingForm;
use app\models\form\user\ProfileForm;
use app\models\form\user\AccountantProfileForm;
use app\widgets\Anchor;
use app\widgets\Label;
use yii\helpers\FileHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const LOGIN_TYPE_DEFAULT = 0;
    const LOGIN_TYPE_EMAIL_AUTH = 1;
    const LOGIN_TYPE_GOOGLE_AUTH = 2;

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const BLOCKED = 1;
    const UNBLOCKED = 0;

    const SCENARIO_ADMIN_CREATE = 'admin_create';

    public $_tableColumnsMeta = false;
    public $_currentTheme;

    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'user',
            'mainAttribute' => 'username',
            'paramName' => 'slug',
            'relatedModels' => ['userMetas', 'logs', 'visitLogs', 'notifications']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            [['username', 'role_id', 'status', 'is_blocked'], 'required'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_INACTIVE,
                    self::STATUS_DELETED
                ]
            ],
            ['is_blocked', 'in', 'range' => [self::BLOCKED, self::UNBLOCKED]],
            ['email', 'email'],
            ['email', 'trim'],
            ['email', 'unique'],
            ['username', 'unique'],
            [['password_hint', 'password_reset_token', 'password_hash', 'photo', 'google2fa', 'google2fa_ts', 'navigation', 'module_access'], 'safe'],
            ['role_id', 'exist', 'targetRelation' => 'role'],
            ['role_id', 'validateRoleId'],
            ['accountant_id', 'validateAccountantId'],
            ['accountant_id', 'integer'],
            ['accountant_id', 'default', 'value' => 0],
            ['login_type', 'integer'],
            ['login_type', 'in', 'range' => [
                self::LOGIN_TYPE_DEFAULT, 
                // self::LOGIN_TYPE_EMAIL_AUTH, 
                self::LOGIN_TYPE_GOOGLE_AUTH, 
            ]],
        ]);
    }

    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'role_id' => 'Role',
            'is_blocked' => 'Blocked',
            'username' => 'Company',
            'accountant_id' => 'Accountant',
            'accountantName' => 'Accountant',
            'userStatusHtml' => 'User Status',
            'blockedStatusHtml' => 'Blocked Status'
        ]);
    }

    public function getIsLoginEmailAuth()
    {
        return $this->login_type == self::LOGIN_TYPE_EMAIL_AUTH;
    }

    public function getLoginTypeLabel()
    {
        return $this->loginTypes[$this->login_type] ?? '';
    }

    public function generateGoogle2Fa()
    {
        $g2fa = new \PragmaRX\Google2FA\Google2FA();
        $exist = true;
        do {
            $google2fa = $g2fa->generateSecretKey();
            if (self::findOne(['google2fa' => $google2fa]) == null) {
                $this->google2fa = $google2fa;
                $this->google2fa_ts = time() / 30;
                $exist = false;
            }
        } while ($exist);
    }

    public function setGoogleAuthenticator()
    {
        if (! $this->google2fa) {
            $this->generateGoogle2Fa();
            self::updateAll([
                'google2fa' => $this->google2fa,
                'google2fa_ts' => $this->google2fa_ts,
            ], ['id' => $this->id]);
        }
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }

    public function getCanDelete()
    {
        return false;
    }

    public function validateAccountantId($attribute, $params)
    {
        if ($this->accountant_id && User::findOne($this->accountant_id) === null) {
            $this->addError($attribute, 'Accountant must set');
        }
    }

    public function validateRoleId($attribute, $params)
    {
        if (App::isGuest() && $this->role->isInactive) {
            $this->addError($attribute, 'Cannot access in-active role');
        }

        if (App::isLogin() && $this->role->isInactive) {
            if (!App::identity()->can('in-active-data', 'role')) {
                $this->addError($attribute, 'User don\'t have access to role');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
        // return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->alias('u')
            ->joinWith('role r')
            ->where([
                'u.access_token' => $token,
                'u.status' => self::STATUS_ACTIVE,
                'u.record_status' => 1,
                'r.record_status' => 1,
            ])
            ->one();
        // throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
        // return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
        // return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            // 'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            // 'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($this->login_type == self::LOGIN_TYPE_DEFAULT || $this->login_type == self::LOGIN_TYPE_EMAIL_AUTH) {
            return Yii::$app->security->validatePassword($password, $this->password_hash);
        }

        if ($this->login_type == self::LOGIN_TYPE_GOOGLE_AUTH) {
            if ($this->google2fa) {
                $google2fa = new \PragmaRX\Google2FA\Google2FA();
                $timestamp = $google2fa->verifyKeyNewer($this->google2fa, $password, $this->google2fa_ts);

                if ($timestamp !== false) {
                    User::updateAll(['google2fa_ts' => $timestamp], ['id' => $this->id]);
                    return true;
                } 
            }
        }

        return false;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getUserStatus()
    {
        return App::params('user_status')[$this->status];
    }

    public function getUserStatusLabel()
    {
        return $this->userStatus['label'];
    }

    public function getBlockedStatus()
    {
        return App::params('user_block_status')[$this->is_blocked];
    }

    public function getBlockedStatusLabel()
    {
        return $this->blockedStatus['label'];
    }

    public function getBlockedStatusHtml()
    {
        if (in_array(App::actionID(), ExportForm::EXPORT_ACTIONS)) {
            return $this->blockedStatus['label'];
        }

        return Label::widget([
            'options' => $this->blockedStatus
        ]);
    }

    public function getUserStatusHtml()
    {
        return Label::widget([
            'options' => $this->userStatus
        ]);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->generateGoogle2Fa();
            $this->generateAuthKey();
            $this->generatePasswordResetToken();
            $this->generateEmailVerificationToken();
            $this->generateAccessToken();
        }

        return true;
    }

    public function getQRCodeurl()
    {
        // USE IT IF THERE's NO INTERNET
        /*$google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $inlineUrl = $google2fa->getQRCodeInline(
            Url::domain(),
            $this->username,
            $this->google2fa
        );
        return $inlineUrl;*/

        $g2fa = new \PragmaRX\Google2FA\Google2FA();
        $text = $g2fa->getQRCodeUrl(
            Url::domain(),
            $this->username,
            $this->google2fa
        );
        return 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$text;
    }

    public function getMySettings()
    {
        return new MySettingForm(['user_id' => $this->id]);
    }

    public function getTheme()
    {
        return $this->mySettings->getTheme();
    }

    public function getCurrentTheme()
    {
        if ($this->_currentTheme === null) {
            $this->_currentTheme = App::ifElse($this->theme, fn($theme) => $theme, App::setting('theme'));
        }
        return $this->_currentTheme;
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public function getTableColumnsMeta($model)
    {
        $user_meta = ($this->_tableColumnsMeta !== false) ? $this->_tableColumnsMeta : UserMeta::findOne([
            'user_id' => $this->id,
            'name' => 'table_columns'
        ]);

        $this->_tableColumnsMeta = $user_meta;

        $table_name = App::tableName($model, false);

        if ($user_meta) {
            $table_columns = json_decode($user_meta->value, true);

            if (in_array($table_name, array_keys($table_columns))) {
                return $table_columns[$table_name];
            }
        }
    }

    public function filterColumns($model, $default = true)
    {
        $table_columns = $this->getTableColumnsMeta($model);

        if ($default) {
            return $table_columns ?: $model->defaultGridColumns;
        }
        return $table_columns ?: [];
    }


    public function getMain_navigation()
    {
        return $this->mainNavigation;
    }

    public function getRoleAccess()
    {
        return App::if ($this->role, fn($role) => $role->role_access);
    }

    public function getRoleName()
    {
        return App::if ($this->role, fn($role) => $role->name);
    }

    public function getModuleAccess()
    {
        return $this->module_access ?: App::if ($this->role, fn($role) => $role->module_access);
    }

    public function getMainNavigation()
    {
        if ($this->navigation) return $this->navigation;

        return App::if ($this->role, fn($role) => $role->main_navigation);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'username',
            'ensureUnique' => true,
        ];

        $behaviors['JsonBehavior']['fields'] = [
            'navigation',
            'module_access',
        ];

        return $behaviors;
    }

    public function getRoleViewUrl()
    {
        return App::if ($this->role, fn($role) => $role->viewUrl);
    }

    public function gridColumns()
    {
        return [
            'photo' => [
                'attribute' => 'id',
                'label' => 'Photo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::image(
                        $model->photo,
                        [
                            'w' => 50,
                            'h' => 50,
                            'quality' => 90,
                            'ratio' => 'false',
                        ],
                        [
                            'loading' => 'lazy',
                            'style' => 'border-radius: 50%;max-width:40px'
                        ]
                    );
                }
            ],
            'username' => [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'email' => ['attribute' => 'email', 'format' => 'raw'],
            'role' => [
                'attribute' => 'roleName',
                'format' => 'raw',
                'label' => 'Role',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->roleName,
                        'link' => $model->roleViewUrl,
                        'text' => true
                    ]);
                }
            ],
            // 'auth_key' => ['attribute' => 'auth_key', 'format' => 'raw'],
            // 'password_hash' => ['attribute' => 'password_hash', 'format' => 'raw'],
            // 'password_reset_token' => ['attribute' => 'password_reset_token', 'format' => 'raw'],
            // 'verification_token' => ['attribute' => 'verification_token', 'format' => 'raw'],
            // 'slug' => ['attribute' => 'slug', 'format' => 'raw'],
            'is_blocked' => [
                'attribute' => 'is_blocked',
                'label' => 'is blocked',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->blockedStatusHtml;
                }
            ],
            'login_type' => [
                'attribute' => 'login_type',
                'format' => 'raw',
                'value' => 'loginTypeSelect'
            ]
        ];
    }

    public function getLoginTypeSelect()
    {
        $options = App::foreach($this->loginTypes, fn ($label, $type) => Html::tag('a', $label, [
            'class' => 'dropdown-item',
            'href' => Url::toRoute(['user/change-login-type', 'slug' => $this->slug, 'type' => $type]),
            'data-confirm' => 'Set Login Type to ' . $label,
            'data-method' => 'post'
        ]));
        return <<< HTML
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {$this->loginTypeLabel}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    {$options}
                </div>
            </div>
        HTML;
    }

    public function getLoginTypes()
    {
        return [
            self::LOGIN_TYPE_DEFAULT => 'Default Authentication',
            // self::LOGIN_TYPE_EMAIL_AUTH => 'Email Authentication',
            self::LOGIN_TYPE_GOOGLE_AUTH => 'Google Authentication',
        ];
    }

    public function detailColumns()
    {
        return [
            [
                'label' => 'Photo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::image(
                        $model->photo,
                        ['w' => 40, 'h' => 40, 'ratio' => 'false', 'quality' => 90],
                        ['style' => 'border-radius: 50%;']
                    );
                }
            ],

            'roleName:raw',
            'username:raw',
            'email:raw',
            [
                'format' => 'raw',
                'value' => fn ($model) => $model->accountant ? Anchor::widget([
                    'title' => $model->accountantName,
                    'link' => ['user/accountant', 'slug' => $model->accountant->slug],
                    'text' => true
                ]): 'N/A',
                'label' => 'Accountant'
            ],
            // 'auth_key:raw',
            // 'password_hash:raw',
            // 'password_hint:raw',
            // 'password_reset_token:raw',
            // 'verification_token:raw',
            // 'slug:raw',
            'userStatusHtml:raw',
            'blockedStatusHtml:raw',
            'login_type' => [
                'attribute' => 'login_type',
                'format' => 'raw',
                'value' => $this->loginTypeSelect
            ]
        ];
    }

    public function getFullname()
    {
        return $this->profile->fullname ?: $this->username;
    }

    public function getAccountantName()
    {
        return App::if($this->accountant, fn ($accountant) => $accountant->fullname);
    }

    public function getAccountant()
    {
        return $this->hasOne(User::class, ['id' => 'accountant_id']);
    }

    public function getBulkActions()
    {
        $bulkActions = parent::getBulkActions();
        $bulkActions['allowed'] = [
            'label' => 'Allowed',
            'process' => 'allowed',
            'icon' => 'check',
            'function' => function ($id) {
                self::allowedAll(['id' => $id]);
            },
        ];
        $bulkActions['blocked'] = [
            'label' => 'Blocked',
            'process' => 'blocked',
            'icon' => 'close',
            'function' => function ($id) {
                self::blockedAll(['id' => $id]);
            },
        ];
        return $bulkActions;
    }

    public function can($action, $controller = '')
    {
        return App::component('access')
            ->userCan($action, $controller);
    }

    public function getMyImageFiles()
    {
        return $this->hasMany(File::class, ['created_by' => 'id'])
            ->onCondition(['extension' => File::EXTENSIONS['image']])
            ->groupBy(['name', 'size', 'extension'])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getProfile()
    {
        if ($this->isAdmin) {
            return new AccountantProfileForm(['user_id' => $this->id]);
        }

        return new ProfileForm(['user_id' => $this->id]);
    }

    public function getIsDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }

    public function getIsNotVerified()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    public function getIsVerified()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function getIsBlocked()
    {
        return $this->is_blocked == 1;
    }

    public static function allowedAll($condition = '')
    {
        return parent::updateAll(['is_blocked' => 0], $condition);
    }

    public static function blockedAll($condition = '')
    {
        return parent::updateAll(['is_blocked' => 1], $condition);
    }

    public function getUserMetas()
    {
        return $this->hasMany(UserMeta::class, ['user_id' => 'id']);
    }

    public function getLogs()
    {
        return $this->hasMany(Log::class, ['user_id' => 'id']);
    }

    public function getVisitLogs()
    {
        return $this->hasMany(VisitLog::class, ['user_id' => 'id']);
    }

    public function getNotifications()
    {
        return $this->hasMany(Notification::class, ['user_id' => 'id']);
    }

    public function getIsDeveloper()
    {
        return App::if ($this->role, fn($role) => $role->getIsDeveloper());
    }

    public function getIsSuperadmin()
    {
        return App::if ($this->role, fn($role) => $role->getIsSuperadmin());
    }

    public function getIsAdmin()
    {
        return App::if ($this->role, fn($role) => $role->getIsAdmin());
    }

    public function getIsAccountant()
    {
        return $this->isAdmin;
    }

    public function getIsClient()
    {
        return App::if ($this->role, fn($role) => $role->getIsClient());
    }

    public static function findByKeywords($keywords = '', $attributes = [], $limit = 10, $andFilterWhere = [])
    {
        return parent::findByKeywordsData(
            $attributes,
            fn($attribute) => self::find()
                ->select("{$attribute} AS data")
                ->alias('u')
                ->joinWith('role r')
                ->groupBy($attribute)
                ->where(['LIKE', $attribute, $keywords])
                ->andFilterWhere($andFilterWhere)
                ->limit($limit)
                ->asArray()
                ->all()
        );
    }

    public static function clientDropdown()
    {
        return self::dropdown('id', 'username', [
            'role_id' => Role::CLIENT
        ]);
    }

    public function getMyClientIds()
    {
        $data = self::dropdown('id', 'username', [
            'role_id' => Role::CLIENT,
            'accountant_id' => App::identity('id')
        ]);

        return array_keys($data);
    }

    public static function clientsDropdown()
    {
        if (App::identity('isAccountant')) {
            return self::dropdown('id', 'username', [
                'role_id' => Role::CLIENT,
                'accountant_id' => App::identity('id')
            ]);
        }
        return self::dropdown('id', 'username', ['role_id' => Role::CLIENT]);
    }

    public function createDirectories() {
        $folders = [
            ['folder' => 'BIR Filling', 'subFolders' => [] ],
            [
                'folder' => 'Legal Document',
                'subFolders' => [
                    'Business Registrations',
                    'Business Permits',
                    'Lease Contracts',
                    'Licenses',
                    'Other Contracts',
                ]
            ], 
            ['folder' => 'KPI', 'subFolders' => []],
            [
                'folder' => 'Payroll',
                'subFolders' => [
                    'Payroll Reports',
                    'SSS Reports',
                    'PHIC Reports',
                    'HDMF Reports',
                    'Tax Reports',
                    'Other Reports',
                ]
            ],
            [
                'folder' => 'Inventory',
                'subFolders' => [
                    'Inventory Report',
                    'Purchases Report',
                    'Sold Inventory Report',
                    'Inventory Count Report',
                    'Other Reports',
                ]
            ],
        ];

        foreach ($folders as $folder) {
            if ($folder['subFolders']) {
                foreach ($folder['subFolders'] as $subFolder) {
                    $filePath = implode(DIRECTORY_SEPARATOR, ['clients', $folder['folder'], $this->email, $subFolder]);
                    FileHelper::createDirectory($filePath);
                }
            }
            else {
                $filePath = implode(DIRECTORY_SEPARATOR, ['clients', $folder['folder'], $this->email]);
                FileHelper::createDirectory($filePath);
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert) return;

        if (!$this->isClient) return;

        $this->createDirectories();
    }

    public function getClientWebroot($tag='tag')
    {
        $webRoot = "@webroot/clients/{$tag}";
        if ($this->isClient) $webRoot = implode('/', [$webRoot, $this->email]);
        return $webRoot;
    }

    public function getClientRoot($tag='tag')
    {
        $webRoot = ['clients', $tag];
        if ($this->isClient) {
            $webRoot[] = $this->email;
        }
        return $webRoot;
    }
}