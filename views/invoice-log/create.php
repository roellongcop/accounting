<?php

use app\models\search\InvoiceLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceLog */

$this->title = 'Create Invoice Log';
$this->params['breadcrumbs'][] = ['label' => 'Invoice Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new InvoiceLogSearch();
?>
<div class="invoice-log-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>