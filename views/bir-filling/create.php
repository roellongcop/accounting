<?php

use app\models\search\BirFillingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\BirFilling */

$this->title = 'Create Bir Filling';
$this->params['breadcrumbs'][] = ['label' => 'Bir Fillings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new BirFillingSearch();
?>
<div class="bir-filling-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>