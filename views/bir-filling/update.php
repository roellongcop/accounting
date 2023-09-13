<?php

use app\models\search\BirFillingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\BirFilling */

$this->title = 'Update BIR Filling: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'BIR Fillings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new BirFillingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="bir-filling-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>