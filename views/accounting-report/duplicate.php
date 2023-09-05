<?php

use app\models\search\AccountingReportSearch;

/* @var $this yii\web\View */
/* @var $model app\models\AccountingReport */

$this->title = 'Duplicate Accounting Report: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Accounting Reports', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new AccountingReportSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="accounting-report-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>