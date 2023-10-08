<?php

use app\models\search\ReceivableSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Receivable */

$this->title = 'Duplicate Receivable: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Receivables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ReceivableSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="receivable-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>