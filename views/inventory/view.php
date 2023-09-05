<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\InventorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = 'Inventory: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new InventorySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="inventory-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>