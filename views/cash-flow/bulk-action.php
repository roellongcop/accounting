<?php

use app\widgets\ConfirmBulkAction;
use app\models\search\CashFlowSearch;
use app\helpers\Html;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => $model->modelLabel, 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['createButton'] = Html::a('Create', $model->createUrl, [
    'class' => 'btn btn-success font-weight-bolder'
]); 
$this->params['searchModel'] = new CashFlowSearch();
$this->params['activeMenuLink'] = $model->activeMenuLink;
?>
<div class="cash-flow-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>