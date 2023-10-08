<?php

use app\models\search\ReceivableSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Receivable */

$this->title = 'Update Receivable: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Receivables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ReceivableSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="receivable-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>