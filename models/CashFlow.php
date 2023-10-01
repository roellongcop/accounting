<?php

namespace app\models;

use app\widgets\Anchor;
use app\widgets\Label;
use app\helpers\App;

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
        return $this->setRules([
            [['name', 'user_id', 'type', 'status', 'amount', 'date'], 'required'],
            [['description'], 'string'],
            [['user_id', 'status', 'type'], 'integer'],
            [['amount'], 'number'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'description' => 'Description',
            'file_tokens' => 'Files',
            'user_id' => 'Client',
            'username' => 'Client',
            'typeBadge' => 'Type',
            'statusBadge' => 'Status',
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
            'type' => ['attribute' => 'type', 'value' => 'typeBadge', 'format' => 'raw'],
            'status' => ['attribute' => 'status', 'value' => 'statusBadge', 'format' => 'raw'],
            'amount' => ['attribute' => 'amount', 'format' => 'raw'],
            'date' => ['attribute' => 'date', 'format' => 'raw'],
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
            'typeBadge:raw',
            'statusBadge:raw',
            'date:raw',
            'amount:raw',
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
            ->alias('cf')
            ->joinWith('user u')
            ->groupBy($attribute)
            ->where(['LIKE', $attribute, $keywords])
            ->andFilterWhere($andFilterWhere)
            ->limit($limit)
            ->asArray()
            ->all());
    }
}