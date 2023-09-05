<?php

use app\models\search\CashFlowSearch;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = 'Duplicate Cash Flow: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Cash Flows', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new CashFlowSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="cash-flow-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>