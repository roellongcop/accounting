<?php

use app\models\search\CashFlowSearch;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = "Update {$model->modelLabel}: $model->mainAttribute";
$this->params['breadcrumbs'][] = ['label' => $model->modelLabel, 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new CashFlowSearch();
$this->params['createButton'] = Html::a('Create', $model->createUrl, [
    'class' => 'btn btn-success font-weight-bolder'
]); 
$this->params['activeMenuLink'] = $model->activeMenuLink;
?>
<div class="cash-flow-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>