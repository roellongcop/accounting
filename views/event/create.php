<?php

use app\models\search\EventSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = 'Create Event';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new EventSearch();
?>
<div class="event-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>