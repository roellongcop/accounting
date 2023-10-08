<?php

use app\widgets\ActiveForm;
use app\models\User;
use app\models\Role;
use app\models\CashFlow;
use app\helpers\App;

/* @var $this yii\web\View */
/* @var $model app\models\search\AccountingReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'generic-search-form'
]); ?>
    <?= $form->search($model, [
        'url' => $this->params['findByKeywordsUrl'] ?? null
    ]) ?>
    <?= $form->dateRange($model) ?> 
    <?= $form->filter($model, 'user_id', User::dropdown('id', 'username', ['role_id' => Role::CLIENT]), 'Client') ?>

    <?= App::if(App::isAction('expense'), $form->filter($model, 'biller', CashFlow::filter('biller'))) ?>

    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model) ?>
    <?= $form->searchButton() ?>
<?php ActiveForm::end(); ?>