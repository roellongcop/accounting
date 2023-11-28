<?php

use app\widgets\ActiveForm;
use app\helpers\App;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Receivable */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'receivable-form']); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->bootstrapSelect($model, 'user_id', User::clientDropdown()) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->datePicker($model, 'invoice_date', ['endDate' => false]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'amount')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->datePicker($model, 'due_date', ['endDate' => false]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'remarks')->textarea(['rows' => 5]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label>Upload Files</label>
            <?= $form->dropzone($model, 'file_tokens', 'Receivable', [
                'files' => $model->files,
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>