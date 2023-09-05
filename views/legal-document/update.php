<?php

use app\models\search\LegalDocumentSearch;

/* @var $this yii\web\View */
/* @var $model app\models\LegalDocument */

$this->title = 'Update Legal Document: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Legal Documents', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new LegalDocumentSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="legal-document-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>