<?php

namespace app\models;

use app\widgets\Anchor;
use app\widgets\Label;
use app\helpers\App;
use app\helpers\Url;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "{{%cash_flows}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $file_tokens
 * @property int $user_id
 * @property int $type
 * @property decimal $amount
 * @property string $date
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class CashFlow extends ActiveRecord
{
    const TYPE_PAYABLE = 0;
    const TYPE_RECEIVABLE = 1;
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cash_flows}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'cash-flow',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
            'dateAttribute' => 'date'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $type_payable = self::TYPE_PAYABLE;

        return $this->setRules([
            [['name', 'user_id', 'type', 'status', 'amount', 'date'], 'required'],
            ['biller', 'required', 'when' => fn ($model) => $model->type == self::TYPE_PAYABLE, 
            'whenClient' => "function (attribute, value) {
                return $('#cashflow-type').val() == {$type_payable};
            }"],

            [['description'], 'string'],
            [['user_id', 'status', 'type'], 'integer'],
            [['amount'], 'number'],
            [['name', 'biller'], 'string', 'max' => 255],
            [['date'], 'string', 'max' => 16],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            ['file_tokens', 'safe'],
            ['status', 'in', 'range' => [
                self::STATUS_PENDING,
                self::STATUS_COMPLETED
            ]],
            ['type', 'in', 'range' => [
                self::TYPE_PAYABLE,
                self::TYPE_RECEIVABLE,
            ]],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Invoice No',
            'description' => 'Description',
            'file_tokens' => 'Files',
            'user_id' => 'Client',
            'username' => 'Client',
            'typeBadge' => 'Type',
            'statusBadge' => 'Status',
            'date' => 'Invoice Date',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CashFlowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CashFlowQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'client' => [
                'visible' => !App::identity('isClient'),
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Anchor::widget([
                        'title' => $model->username,
                        'link' => $model->userViewUrl,
                        'text' => true
                    ]);
                }
            ],
            'invoice_no' => [
                // 'label' => 'title',
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
           'biller' => [
                'attribute' => 'biller', 
                'format' => 'raw',
                // 'visible' => App::isControllerAction('cash-flow/expense')
            ],
            'amount' => ['attribute' => 'amount', 'format' => 'number'],
            'invoice_date' => ['attribute' => 'date', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            [
                'label' => $this->getAttributeLabel('username'),
                'value' => 'username',
                'format' => 'raw',
                'visible' => !App::identity('isClient'),
            ],
            [
                'label' => $this->getAttributeLabel('biller'),
                'value' => 'biller',
                'format' => 'raw',
            ],
            'date:raw',
            'amount:number',
            'name:raw',
            'description:raw',
        ];
    }

    public function getStatusBadge()
    {
        return Label::widget(['options' => App::params('cash_flow_statuses')[$this->status]]);
    }

    public function getTypeBadge()
    {
        return Label::widget(['options' => App::params('cash_flow_types')[$this->type]]);
    }

    public function getFiles()
    {
        return File::findAll(['token' => $this->file_tokens]);
    }

    public function getFilePreviews()
    {
        return App::foreach ($this->file_tokens, function ($token) {
            return Html::image($token, ['w' => 100, 'h' => 100, 'ratio' => 'false'], [
                'class' => 'img-thumbnail'
            ]);
        });
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUsername()
    {
        return App::if($this->user, fn ($user) => $user->username);
    }

    public function getUserViewUrl()
    {
        return App::if ($this->user, fn($user) => $user->viewUrl);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'file_tokens',
        ];
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'name',
            'ensureUnique' => true,
        ];
        $behaviors['DateBehavior'] = [
            'class' => 'app\behaviors\DateBehavior',
            'attributes' => ['date'],
        ];

        return $behaviors;
    }

    public static function findByKeywords($keywords = '', $attributes = [], $limit = 10, $andFilterWhere = [])
    {
        return parent::findByKeywordsData($attributes, fn($attribute) => self::find()
            ->select("{$attribute} AS data")
            ->alias('cf')
            ->joinWith('user u')
            ->groupBy($attribute)
            ->where(['LIKE', $attribute, $keywords])
            ->andFilterWhere($andFilterWhere)
            ->limit($limit)
            ->asArray()
            ->all());
    }

    public function isTypeValid($type=self::TYPE_RECEIVABLE)
    {
        return (new CashFlow(['type' => $type]))->validate('type');
    }

    public static function income()
    {
        return new self(['type' => self::TYPE_RECEIVABLE]);
    }

    public static function expense()
    {
        return new self(['type' => self::TYPE_PAYABLE]);
    }

    public function getIsIncome()
    {
        return $this->type === self::TYPE_RECEIVABLE;
    }

    public function getIsExpense()
    {
        return $this->type === self::TYPE_PAYABLE;
    }

    public function getActionId()
    {
        return $this->isIncome ? 'income': 'expense';
    }

    public function getModelLabel()
    {
        return $this->isIncome ? 'Income': 'Expense';
    }

    public function getIndexUrl($fullpath = true)
    {
        if ($this->checkLinkAccess($this->actionId)) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), $this->actionId]),
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getFindByKeywordsUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('find-by-keywords')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'find-by-keywords']),
                'type' => $this->isIncome ? self::TYPE_RECEIVABLE: self::TYPE_PAYABLE
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getCreateUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('create')) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'create']),
                'type' => $this->type
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getPrintUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('print')) {
            $url = [
                implode('/', [$this->controllerID(), 'print']),
                'type' => $this->type
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getExportPdfUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('export-pdf')) {
            $url = [
                implode('/', [$this->controllerID(), 'export-pdf']),
                'type' => $this->type
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getExportCsvUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('export-csv')) {
            $url = [
                implode('/', [$this->controllerID(), 'export-csv']),
                'type' => $this->type
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getExportXlsUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('export-xls')) {
            $url = [
                implode('/', [$this->controllerID(), 'export-xls']),
                'type' => $this->type
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getExportXlsxUrl($fullpath = true)
    {
        if ($this->checkLinkAccess('export-xlsx')) {
            $url = [
                implode('/', [$this->controllerID(), 'export-xlsx']),
                'type' => $this->type
            ];
            return ($fullpath) ? Url::toRoute($url, true) : $url;
        }
    }

    public function getActiveMenuLink()
    {
        return $this->isIncome 
            ? Url::toRoute(['cash-flow/income'])
            : Url::toRoute(['cash-flow/expense']);
    }
}