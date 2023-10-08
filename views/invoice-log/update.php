<?php

use app\models\search\InvoiceLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceLog */

$this->title = 'Update Invoice Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Invoice Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new InvoiceLogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="invoice-log-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>