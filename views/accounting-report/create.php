<?php

use app\models\search\AccountingReportSearch;

/* @var $this yii\web\View */
/* @var $model app\models\AccountingReport */

$this->title = 'Create Accounting Report';
$this->params['breadcrumbs'][] = ['label' => 'Accounting Reports', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new AccountingReportSearch();
?>
<div class="accounting-report-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>