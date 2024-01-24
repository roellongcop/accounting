<?php

namespace app\models;

use app\widgets\Anchor;
use app\helpers\App;

/**
 * This is the model class for table "{{%payrolls}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $file_tokens
 * @property int $user_id
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Payroll extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%payrolls}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'payroll',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name', 'user_id'], 'required'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            ['file_tokens', 'safe']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'file_tokens' => 'Files',
            'user_id' => 'Client',
            'username' => 'Client',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PayrollQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PayrollQuery(get_called_class());
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
            'name' => [
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
            'description' => ['attribute' => 'description', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            [
                'label' => $this->getAttributeLabel('username'),
                'value' => fn ($model) => $model->username,
                'format' => 'raw',
                'visible' => !App::identity('isClient'),
            ],
            'name:raw',
            'description:raw',
        ];
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

        return $behaviors;
    }

    public function getDetailView()
    {
        return App::partial('/layouts/generic/view', [
            'model' => $this
        ]);
    }

    public static function findByKeywords($keywords = '', $attributes = [], $limit = 10, $andFilterWhere = [])
    {
        return parent::findByKeywordsData($attributes, fn($attribute) => self::find()
            ->select("{$attribute} AS data")
            ->alias('p')
            ->joinWith('user u')
            ->groupBy($attribute)
            ->where(['LIKE', $attribute, $keywords])
            ->andFilterWhere($andFilterWhere)
            ->limit($limit)
            ->asArray()
            ->all());
    }
}