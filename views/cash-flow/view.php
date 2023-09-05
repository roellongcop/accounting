<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\CashFlowSearch;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = 'Cash Flow: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Cash Flows', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new CashFlowSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="cash-flow-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>