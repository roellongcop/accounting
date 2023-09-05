<?php

use app\models\search\CashFlowSearch;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = 'Update Cash Flow: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Cash Flows', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new CashFlowSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="cash-flow-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>