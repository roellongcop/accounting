<?php

use app\widgets\ActiveForm;
use app\widgets\ModelAttribute;
use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Inflector;

$this->registerWidgetJsFile('payment-button');

$this->registerJs(<<< JS
    new PaymentButtonWidget({widgetId: '{$widgetId}'}).init();
JS);
?>

<div class="payment-button-widget" id="payment-button-<?= $widgetId ?>" style="display: contents;">
  
  <?= Html::button($buttonLabel, $buttonOptions) ?>
  <!-- Modal-->
  <div class="modal fade" id="staticBackdrop-<?= $widgetId ?>"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop-<?= $widgetId ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $buttonLabel ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <?php $form = ActiveForm::begin([
            'id' => 'receive-payment-' . $widgetId,
            'enableAjaxValidation' => true,
            'action' => $model->getReceivePaymentUrl(false),
            'validationUrl' => $model->getReceivePaymentValidationUrl(false)
          ]); ?>
            <div class="row">
              <div class="col-md-6">
                <?= ModelAttribute::widget([
                  'header' => $model->getAttributeLabel('amount_paid'),
                  'content' => App::formatter()->asNumber($model->amount_paid)
                ]) ?>
              </div>
              <div class="col-md-6">
                <?= ModelAttribute::widget([
                  'header' => $model->getAttributeLabel('balance'),
                  'content' => App::formatter()->asNumber($model->balance)
                ]) ?>
              </div>
            </div>
            <?= $form->field($model, 'pay_amount')->textInput(['type' => 'number']) ?>
            <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>

            <?= $form->dropzone($model, 'receive_payment_files', Inflector::camel2words(App::className($model))) ?>
            
          <?php ActiveForm::end(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary font-weight-bold btn-confirm">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>
