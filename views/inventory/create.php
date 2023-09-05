<?php

use app\models\search\InventorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = 'Create Inventory';
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new InventorySearch();
?>
<div class="inventory-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>