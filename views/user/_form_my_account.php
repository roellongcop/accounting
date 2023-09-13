<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\search\RoleSearch;
use app\widgets\ActiveForm;
use app\widgets\Reminder;
use app\widgets\ModelAttribute;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'user-form-my-account']); ?>

    <?= Reminder::widget([
        'head' => 'Important Notice!',
        'message' => 'Email cannot be updated',
        'type' => 'info'
    ]) ?>
    <div class="row my-5">
        <div class="col-md-5">
            
            <?= ModelAttribute::widget([
                'model' => $model,
                'attribute' => 'email',
            ]) ?>
            <?= App::identity('isClient') ?'': $form->bootstrapSelect($model, 'role_id', RoleSearch::dropdown('id', 'name', [
                'id' => App::identity('roleAccess')
            ])) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->bootstrapSelect($model, 'status', App::keyMapParams('user_status'), [
                'searchable' => false,
            ]) ?>
          
            <?= $form->recordStatus($model) ?>
            <?= $form->bootstrapSelect($model, 'is_blocked', App::keyMapParams('user_block_status'), [
                'searchable' => false,
            ]) ?>
        </div>
        <div class="col-md-5">
            <?= Html::image($model->photo, ['w' => 200], [
                'class' => 'img-thumbnail user-photo',
                'loading' => 'lazy',
            ] ) ?>
            <br>

            <?= $form->imageGallery($model, 'photo', 'User', [
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('.user-photo').attr('src', s.src);
                    }
                ",
            ]) ?>
        </div>
    </div>
    <div class="form-group"><br>
		<?= $form->buttons() ?>
    </div>
<?php ActiveForm::end(); ?>

