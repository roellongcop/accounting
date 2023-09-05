<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BirFilling */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'bir-filling-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'files')->textarea(['rows' => 6]) ?>
            <?= $form->recordStatus($model) ?>
        </div>
    </div>
    <div class="form-group">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>