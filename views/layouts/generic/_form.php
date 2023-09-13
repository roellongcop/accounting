<?php

use app\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\AccountingReport */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => $id ?? 'generic-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->bootstrapSelect($model, 'user_id', User::clientDropdown()) ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->dropzone($model, 'file_tokens', $model::class, [
                'files' => $model->files,
            ]) ?>
        </div>
    </div>
    <div class="form-group mt-10">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>