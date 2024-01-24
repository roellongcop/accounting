<?php

use app\widgets\ActiveForm;
use app\models\User;
use app\models\Role;
use app\helpers\App;

/* @var $this yii\web\View */
/* @var $model app\models\search\ReceivableSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'receivable-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= App::if(!App::identity('isClient'), $form->filter($model, 'user_id', User::dropdown('id', 'username', ['role_id' => Role::CLIENT]), 'Client')) ?>
    
    <?= $form->filter($model, 'status', App::keyMapParams('receivable_status')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model) ?>
    <?= $form->searchButton() ?>
<?php ActiveForm::end(); ?>