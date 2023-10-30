<?php

use app\widgets\ActiveForm;
use app\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'user-form-change-password']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password_hint')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <div class="text-center">
                <?= Html::img($user->qRCodeurl, [
                    'class' => 'img-thumbnail symbol'
                ]) ?>
                <p class="lead font-weight-bold mt-10">Scan These QR Code to add to Google Authenticator</p>
            </div>
        </div>
    </div>
    <div class="form-group">
		<?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>