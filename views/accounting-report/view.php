<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\AccountingReportSearch;

/* @var $this yii\web\View */
/* @var $model app\models\AccountingReport */

$this->title = 'Accounting Report: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Accounting Reports', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new AccountingReportSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="accounting-report-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>