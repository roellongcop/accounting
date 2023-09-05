<?php

use app\models\search\CashFlowSearch;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = 'Create Cash Flow';
$this->params['breadcrumbs'][] = ['label' => 'Cash Flows', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new CashFlowSearch();
?>
<div class="cash-flow-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>