<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%inventories}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $files
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Inventory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%inventories}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'inventory',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name'], 'required'],
            [['description', 'files'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'files' => 'Files',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\InventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\InventoryQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
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
            'files' => ['attribute' => 'files', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'description:raw',
            'files:raw',
        ];
    }
}