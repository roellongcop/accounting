<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\EventSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = 'Event: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new EventSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="event-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>