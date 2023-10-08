<?php

use app\models\search\ReceivableSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Receivable */

$this->title = 'Create Receivable';
$this->params['breadcrumbs'][] = ['label' => 'Receivables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ReceivableSearch();
?>
<div class="receivable-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>