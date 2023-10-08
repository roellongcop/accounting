<?php

use app\widgets\ActiveForm;
use app\models\User;
use app\helpers\App;
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
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->datePicker($model, 'date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'amount')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <?php if ($model->isExpense): ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'biller')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div> 

    <div class="form-group mt-10">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>