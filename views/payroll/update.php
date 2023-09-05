<?php

use app\models\search\PayrollSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */

$this->title = 'Update Payroll: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Payrolls', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new PayrollSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="payroll-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>