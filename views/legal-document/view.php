<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\LegalDocumentSearch;

/* @var $this yii\web\View */
/* @var $model app\models\LegalDocument */

$this->title = 'Legal Document: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Legal Documents', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new LegalDocumentSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="legal-document-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>