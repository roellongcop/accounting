<?php

use app\models\search\BirFillingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\BirFilling */

$this->title = 'Duplicate BIR Filling: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'BIR Fillings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new BirFillingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="bir-filling-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>