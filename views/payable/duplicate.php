<?php

use app\models\search\PayableSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payable */

$this->title = 'Duplicate Payable: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Payables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new PayableSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="payable-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>