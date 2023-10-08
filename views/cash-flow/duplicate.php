<?php

use app\models\search\CashFlowSearch;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = "Duplicate {$model->modelLabel}: $model->mainAttribute";
$this->params['breadcrumbs'][] = ['label' => $model->modelLabel, 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new CashFlowSearch();
$this->params['createButton'] = Html::a('Create', $model->createUrl, [
    'class' => 'btn btn-success font-weight-bolder'
]); 
$this->params['activeMenuLink'] = $model->activeMenuLink;
?>
<div class="cash-flow-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>