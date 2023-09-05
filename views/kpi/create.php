<?php

use app\models\search\KpiSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Kpi */

$this->title = 'Create Kpi';
$this->params['breadcrumbs'][] = ['label' => 'Kpis', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new KpiSearch();
?>
<div class="kpi-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>