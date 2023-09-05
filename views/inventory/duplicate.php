<?php

use app\models\search\InventorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = 'Duplicate Inventory: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new InventorySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="inventory-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>