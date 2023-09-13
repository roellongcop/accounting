<?php

use app\models\search\KpiSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Kpi */

$this->title = 'Create KPI';
$this->params['breadcrumbs'][] = ['label' => 'KPIs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new KpiSearch();
?>
<div class="kpi-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>