<?php

use app\models\search\CashFlowSearch;

/* @var $this yii\web\View */
/* @var $model app\models\CashFlow */

$this->title = "Create {$model->modelLabel}";
$this->params['breadcrumbs'][] = ['label' => $model->modelLabel, 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new CashFlowSearch();
$this->params['activeMenuLink'] = $model->activeMenuLink;
?>
<div class="cash-flow-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>