<?php

use app\widgets\ActiveForm;
use app\models\User;
use app\helpers\App;
use yii\helpers\Inflector;
/* @var $this yii\web\View */
/* @var $model app\models\AccountingReport */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => $id ?? 'generic-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->bootstrapSelect($model, 'user_id', User::clientDropdown()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->bootstrapSelect($model, 'type', App::keyMapParams('cash_flow_types')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->bootstrapSelect($model, 'status', App::keyMapParams('cash_flow_statuses')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->datePicker($model, 'date') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
			<?= $form->field($model, 'amount')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-6">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        	<label>Upload Document/s</label>
			<?= $form->dropzone($model, 'file_tokens', Inflector::camel2words(App::className($model)), [
                'files' => $model->files,
            ]) ?>
        </div>
    </div>

    <div class="form-group mt-10">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>