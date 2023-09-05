<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\BirFillingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\BirFilling */

$this->title = 'Bir Filling: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Bir Fillings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new BirFillingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="bir-filling-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>