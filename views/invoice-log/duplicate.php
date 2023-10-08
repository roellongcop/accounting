<?php

use app\models\search\InvoiceLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceLog */

$this->title = 'Duplicate Invoice Log: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Invoice Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new InvoiceLogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="invoice-log-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>