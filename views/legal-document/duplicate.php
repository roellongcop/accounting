<?php

use app\models\search\LegalDocumentSearch;

/* @var $this yii\web\View */
/* @var $model app\models\LegalDocument */

$this->title = 'Duplicate Legal Document: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Legal Documents', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new LegalDocumentSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="legal-document-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>