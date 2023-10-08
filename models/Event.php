<?php

namespace app\models;

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%accounting_reports}}".
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
class Event extends ActiveRecord
{
    const RED = 'danger';
    const BLUE = 'primary';
    const YELLOW = 'warning';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'event',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
            'dateAttribute' => 'start'
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['title'] = 'name';
        $fields['backgroundColor'] = 'color';
        $fields['className'] = fn ($model) => "fc-event-default fc-event-solid-{$model->color}";

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name', 'user_id', 'start', 'end', 'color'], 'required'],
            [['description'], 'string'],
            [['user_id', 'one_day'], 'integer'],
            [['name', 'start', 'end'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 8],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            ['file_tokens', 'safe'],
            [['start', 'end'], 'validateDates'],
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
            'start' => 'Start',
            'end' => 'End',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EventQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'client' => [
                'attribute' => 'username',
                'format' => 'raw',
                'visible' => !App::identity('isClient'),
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
            'start' => ['attribute' => 'start', 'format' => 'date'],
            'end' => ['attribute' => 'end', 'format' => 'date'],
            'description' => ['attribute' => 'description', 'format' => 'raw'],
            'description' => ['attribute' => 'description', 'format' => 'raw'],
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
            'name:raw',
            'start:date',
            'end:date',
            'description:raw',
        ];
    }

    public function getFooterDetailColumns()
    {
        $columns = parent::getFooterDetailColumns();
        unset($columns['recordStatusHtml']);

        return $columns;
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

    public function getAccountant()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->onCondition([User::tableName() . '.accountant_id' => App::identity('id')]);
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
            'attributes' => ['start', 'end'],
            'inFormat' => 'Y-m-d H:i:s',
            'outFormat' => 'Y-m-d H:i:s'
        ];

        return $behaviors;
    }

    public static function findByKeywords($keywords = '', $attributes = [], $limit = 10, $andFilterWhere = [])
    {
        return parent::findByKeywordsData($attributes, fn($attribute) => self::find()
            ->select("{$attribute} AS data")
            ->alias('e')
            ->joinWith('user u')
            ->groupBy($attribute)
            ->where(['LIKE', $attribute, $keywords])
            ->andFilterWhere($andFilterWhere)
            ->limit($limit)
            ->asArray()
            ->all());
    }

    public function validateDates($attribute, $params)
    {
        $start = strtotime($this->start);
        $end = strtotime($this->end);

        if ($end <= $start) {
            $this->addError('end', 'End date must be greater than start date.');
        }
    }

    public function getValidationUrl()
    {
        if ($this->isNewRecord) {
            return Url::toRoute(['event/create', 'ajaxValidate' => true]);
        }

        return Url::toRoute([
            'event/create', 
            'slug' => $this->slug, 
            'ajaxValidate' => true
        ]);
    }

    public function getActionUrl()
    {
        return $this->isNewRecord ? $this->createUrl: $this->updateUrl;
    }


}