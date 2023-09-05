<?php

use app\models\search\PayrollSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payroll */

$this->title = 'Create Payroll';
$this->params['breadcrumbs'][] = ['label' => 'Payrolls', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new PayrollSearch();
?>
<div class="payroll-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>