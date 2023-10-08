<?php

namespace app\models;

use app\widgets\Anchor;
use app\widgets\Label;
use app\helpers\Url;
use app\helpers\App;
use app\helpers\Html;

/**
 * This is the model class for table "{{%invoice_logs}}".
 *
 * @property int $id
 * @property int $status
 * @property int $type
 * @property string|null $remarks
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class InvoiceLog extends ActiveRecord
{
	const TYPE_RECEIVABLE = 0;
	const TYPE_PAYABLE = 1;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%invoice_logs}}';
	}

	public function config()
	{
		return [
			'controllerID' => 'invoice-log',
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
			[['status', 'type', 'model_id'], 'required'],
			[['status', 'type', 'model_id'], 'integer'],
			[['remarks'], 'string'],
			[['type'], 'in', 'range' => [
				self::TYPE_RECEIVABLE,
				self::TYPE_PAYABLE,
			]],
			['model_id', 'validateModelId'],
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
			'status' => 'Status',
			'type' => 'Type',
			'remarks' => 'Remarks',
		]);
	}

	/**
	 * {@inheritdoc}
	 * @return \app\models\query\InvoiceLogQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\InvoiceLogQuery(get_called_class());
	}
	 
	public function gridColumns()
	{
		return [
			'type' => [
				'attribute' => 'type', 
				'format' => 'raw',
				'value' => function($model) {
					return Anchor::widget([
						'title' => $model->type,
						'link' => $model->viewUrl,
						'text' => true
					]);
				}
			],
			'remarks' => ['attribute' => 'remarks', 'format' => 'raw'],
		];
	}

	public function detailColumns()
	{
		return [
			'type:raw',
			'remarks:raw',
		];
	}

	public function getCreatorImage()
	{
		if (($createdBy = $this->createdBy) != null) {
			return Url::image($createdBy->photo ?: '');
		}
	}


	public function getLabel()
	{
		switch ($this->type) {
			case self::TYPE_PAYABLE:
				return Label::widget([
					'options' => App::params('payable_status')[$this->status]
				]);
			
			case self::TYPE_RECEIVABLE:
				return Label::widget([
					'options' => App::params('receivable_status')[$this->status]
				]);
			default:
				break;
		}
	}

	public function getModel()
	{
		switch ($this->type) {
			case self::TYPE_PAYABLE:
				return Payable::findOne($this->model_id);
			
			case self::TYPE_RECEIVABLE:
				return Receivable::findOne($this->model_id);

			default:
				break;
		}
	}

	public function validateModelId($attribute, $params)
	{
		if ($this->model === null) {
			$this->addError($attribute, 'Invalid Invoice type');
		}
	}

	public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors['JsonBehavior']['fields'] = [
      'file_tokens',
    ];

    return $behaviors;
  }

  public function getFiles()
  {
    return File::findAll(['token' => $this->file_tokens]);
  }

  public function getFilesPreview()
  {
    if (($files = $this->files) === null) return;

    return App::foreach($files, fn ($file) => Html::a(Html::image($file, ['w' => 50], [
    	'class' => 'img-thumbnail'
    ]), $file->downloadUrl));
  }
}