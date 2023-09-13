<?php

use app\widgets\Anchors;
use app\models\search\KpiSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Kpi */

$this->title = 'KPI: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'KPIs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new KpiSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="kpi-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= $model->detailView ?>
</div>