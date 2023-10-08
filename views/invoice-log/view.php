<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\InvoiceLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceLog */

$this->title = 'Invoice Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Invoice Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new InvoiceLogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="invoice-log-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>