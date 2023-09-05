<?php

use app\models\search\PayrollSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */

$this->title = 'Duplicate Payroll: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Payrolls', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new PayrollSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="payroll-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>