<?php

use app\models\search\PayableSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payable */

$this->title = 'Create Payable';
$this->params['breadcrumbs'][] = ['label' => 'Payables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new PayableSearch();
?>
<div class="payable-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>