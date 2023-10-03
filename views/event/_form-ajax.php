<?php

use app\widgets\ActiveForm;
use app\models\User;
?>

<?php $form = ActiveForm::begin([
    'id' => 'event-form',
    'enableAjaxValidation' => true,
    'validationUrl' => $model->validationUrl,
    'action' => $model->actionUrl,
]); ?>
    <?= $form->bootstrapSelect($model, 'user_id', User::clientDropdown()) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->bootstrapSelect($model, 'color', [
                'primary' => 'Blue',
                'warning' => 'Yellow',
                'danger' => 'Red',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->dateTimePicker($model, 'start') ?>
        </div>
        <div class="col-md-6">
            <?= $form->dateTimePicker($model, 'end') ?>
        </div>
    </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
<?php ActiveForm::end(); ?>