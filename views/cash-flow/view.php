<?php

use app\widgets\Anchors;
use app\models\search\CashFlowSearch;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = "{$model->modelLabel}: $model->mainAttribute";
$this->params['breadcrumbs'][] = ['label' => $model->modelLabel, 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new CashFlowSearch();
$this->params['createButton'] = Html::a('Create', $model->createUrl, [
    'class' => 'btn btn-success font-weight-bolder'
]); 
$this->params['activeMenuLink'] = $model->activeMenuLink;
?>
<div class="cash-flow-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= $model->detailView ?>
</div>