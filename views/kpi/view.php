<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\KpiSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Kpi */

$this->title = 'Kpi: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Kpis', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new KpiSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="kpi-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>