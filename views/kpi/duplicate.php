<?php

use app\models\search\KpiSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Kpi */

$this->title = 'Duplicate KPI: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'KPIs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new KpiSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="kpi-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>