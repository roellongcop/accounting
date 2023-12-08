<?php

namespace app\models;

use app\widgets\Anchor;
use app\widgets\Label;
use app\widgets\PaymentButton;
use app\helpers\App;
use app\helpers\Html;
use yii\db\Expression;

/**
 * This is the model class for table "{{%receivables}}".
 *
 * @property int $id
 * @property string $title
 * @property string $due_date
 * @property string|null $description
 * @property string|null $file_tokens
 * @property int $status
 * @property float $amount
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Receivable extends ActiveRecord
{
  const SCENARIO_RECEIVE_PAYMENT = 'receive-payment';

  const UN_PAID = 0;
  const PARTIAL_PAID = 1;
  const COMPLETE_PAID = 2;

  public $remarks;
  public $pay_amount;
  public $receive_payment_files = [];

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return '{{%receivables}}';
  }

  public function config()
  {
    return [
      'controllerID' => 'receivable',
      'mainAttribute' => 'title',
      'paramName' => 'id',
      'dateAttribute' => 'due_date',
      'excelIgnoreAttributes' => ['receive_payment']
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return $this->setRules([
      ['pay_amount', 'required', 'on' => self::SCENARIO_RECEIVE_PAYMENT],
      [['title', 'due_date', 'amount', 'description', 'user_id', 'invoice_date'], 'required'],
      [['description'], 'string'],
      [['invoice_date'], 'string', 'max' => 16],
      [['status'], 'integer'],
      [['amount', 'amount_paid', 'pay_amount'], 'number'],
      [['title', 'due_date'], 'string', 'max' => 255],
      [['file_tokens', 'remarks', 'receive_payment_files'], 'safe'],
      [['status'], 'in', 'range' => [
        self::UN_PAID,
        self::PARTIAL_PAID,
        self::COMPLETE_PAID,
      ]],
      ['user_id', 'exist', 'targetRelation' => 'user'],
      [['amount', 'amount_paid', 'pay_amount'], 'compare', 'compareValue' => 0, 'operator' => '>='],
      ['pay_amount', 'validatePayAmount']
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return $this->setAttributeLabels([
      'id' => 'ID',
      'title' => 'Invoice No.',
      'due_date' => 'Due Date',
      'description' => 'Customer',
      'file_tokens' => 'Files',
      'status' => 'Status',
      'amount' => 'Amount',
      'statusBadge' => 'Status',
      'user_id' => 'Client',
      'username' => 'Client',
    ]);
  }

  /**
   * {@inheritdoc}
   * @return \app\models\query\ReceivableQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\query\ReceivableQuery(get_called_class());
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
      'invoice_no' => [
        'attribute' => 'title', 
        'format' => 'raw',
        'value' => function($model) {
          return Anchor::widget([
            'title' => $model->title,
            'link' => $model->viewUrl,
            'text' => true
          ]);
        }
      ],
      'invoice_date' => ['attribute' => 'invoice_date', 'format' => 'raw',],
      'due_date' => ['attribute' => 'due_date', 'format' => 'dueAndLabel',],
      'customer' => ['attribute' => 'description', 'format' => 'raw', 'label' => 'Customer'],
      'amount' => ['attribute' => 'amount', 'format' => 'number'],
      'amount_paid' => ['attribute' => 'amount_paid', 'format' => 'number'],
      'balance' => ['attribute' => 'balance', 'format' => 'number', 'value' => 'balance'],
      'status' => ['attribute' => 'status', 'format' => 'raw', 'value' => 'statusBadge'],
    ];
  }

  public function getFooterGridColumns()
  {
    $columns = [
      'created_at' => ['attribute' => 'created_at', 'format' => 'fulldate'],
      'last_updated' => [
        'attribute' => 'updated_at',
        'label' => 'last updated',
        'format' => 'ago',
      ],
      'receive_payment' => [
        'attribute' => 'id',
        'label' => 'Payment',
        'format' => 'raw',
        'value' => 'paymentButton',
        'visible' => !App::identity('isClient')
      ]
    ];

    if (App::isLogin() && App::identity()->can('in-active-data', $this->controllerID())) {
      $columns['active'] = [
        'attribute' => 'record_status',
        'label' => 'active',
        'format' => 'raw',
        'value' => 'recordStatusHtml',
      ];
    }

    return $columns;
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
      'title:raw',
      'invoice_date:raw',
      'due_date:dueAndLabel',
      'description:raw',
      'amount:number',
      'amount_paid:number',
      'balance:number',
      'statusBadge:raw',
    ];
  }

  public function getStatusBadge()
  {
    return Label::widget(['options' => App::params('receivable_status')[$this->status]]);
  }

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors['JsonBehavior']['fields'] = [
      'file_tokens',
    ];
     
    $behaviors['DateBehavior'] = [
      'class' => 'app\behaviors\DateBehavior',
      'attributes' => ['due_date', 'invoice_date'],
    ];

    return $behaviors;
  }

  public function getBalance()
  {
    return $this->amount - $this->amount_paid;
  }

  public function validatePayAmount($attribute, $params)
  {
    if ($this->pay_amount > $this->amount) {
      $this->addError($attribute, 'Pay Amount must be less than or equal to Amount ' .  App::formatter()->asNumber($this->amount));
    }

    if ($this->pay_amount > $this->balance) {
      $this->addError($attribute, 'Pay Amount must be less than or equal to balanced ' . App::formatter()->asNumber($this->balance));
    }
  }

  public function beforeSave($insert)
  {
    if (!parent::beforeSave($insert)) return false;

    if ($insert) {
      $this->status = self::UN_PAID;
      return true;
    }

    $this->amount_paid = ($this->amount_paid ?: 0) + $this->pay_amount;

    if ($this->amount_paid >= $this->amount) {
      $this->amount_paid = $this->amount;
      $this->status = self::COMPLETE_PAID;
      return true;
    }

    if ($this->amount_paid > 0) {
      $this->status = self::PARTIAL_PAID;
    }

    return true;
  }

  public function afterSave($insert, $changedAttributes)
  {
    parent::afterSave($insert, $changedAttributes);
    $log = new InvoiceLog([
      'model_id' => $this->id,
      'remarks' => $this->remarks,
      'status' => $this->status,
      'file_tokens' => $insert ? $this->file_tokens: $this->receive_payment_files,
      'type' => InvoiceLog::TYPE_RECEIVABLE,
    ]);

    $log->save();
  }

  public function getFiles()
  {
    return File::findAll(['token' => $this->file_tokens]);
  }

  public function getDetailView()
  {
    return App::partial('/layouts/generic/view', [
      'model' => $this
    ]);
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

  public static function findByKeywords($keywords = '', $attributes = [], $limit = 10, $andFilterWhere = [])
  {
    return parent::findByKeywordsData($attributes, fn($attribute) => self::find()
      ->select("{$attribute} AS data")
      ->alias('r')
      ->joinWith('user u')
      ->groupBy($attribute)
      ->where(['LIKE', $attribute, $keywords])
      ->andFilterWhere($andFilterWhere)
      ->limit($limit)
      ->asArray()
      ->all());
  }

  public function getInvoiceLogs()
  {
    return $this->hasMany(InvoiceLog::class, ['model_id' => 'id'])
      ->onCondition(['type' => InvoiceLog::TYPE_RECEIVABLE]);
  }

  public function getReceivePaymentUrl($fullpath = true)
  {
    if ($this->checkLinkAccess('receive-payment')) {
      $paramName = $this->paramName();
      $url = [
        implode('/', [$this->controllerID(), 'receive-payment']),
        $paramName => $this->{$paramName}
      ];
      return ($fullpath) ? Url::toRoute($url, true) : $url;
    }
  }

  public function getReceivePaymentValidationUrl($fullpath = true)
  {
    if ($this->checkLinkAccess('receive-payment')) {
      $paramName = $this->paramName();
      $url = [
        implode('/', [$this->controllerID(), 'receive-payment']),
        'ajaxValidate' => true,
        $paramName => $this->{$paramName}
      ];
      return ($fullpath) ? Url::toRoute($url, true) : $url;
    }
  }

  public function getPaymentButton()
  {
    return PaymentButton::widget([
      'id' => App::randomString(10) . $this->id,
      'model' => $this,
      'buttonOptions' => [
        'type' => 'button',
        'class' => 'btn btn-outline-primary btn-sm font-weight-bold',
        'data-toggle' => 'modal',
      ]
    ]);
  }

  public function getHeaderGridColumns()
  {
    $columns = parent::getHeaderGridColumns();
    unset($columns['checkbox']);

    return $columns;
  }
}