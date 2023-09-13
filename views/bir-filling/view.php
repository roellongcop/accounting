<?php

use app\widgets\Anchors;
use app\models\search\BirFillingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\BirFilling */

$this->title = 'BIR Filling: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'BIR Fillings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new BirFillingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="bir-filling-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= $model->detailView ?>
</div>