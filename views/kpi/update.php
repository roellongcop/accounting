<?php

use app\models\search\KpiSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Kpi */

$this->title = 'Update Kpi: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Kpis', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new KpiSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="kpi-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>