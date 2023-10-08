<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceLog */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'invoice-log-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'type')->textInput() ?>
			<?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>
            <?= $form->recordStatus($model) ?>
        </div>
    </div>
    <div class="form-group">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>