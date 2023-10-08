<?php

use app\models\search\PayableSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Payable */

$this->title = 'Update Payable: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Payables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new PayableSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="payable-update-page">
	<?= $this->render('_form', [
    'model' => $model,
  ]) ?>
</div>