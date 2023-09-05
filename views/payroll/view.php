<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\PayrollSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */

$this->title = 'Payroll: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Payrolls', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new PayrollSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="payroll-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>