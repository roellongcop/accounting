<?php

use app\models\search\InventorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = 'Update Inventory: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new InventorySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="inventory-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>