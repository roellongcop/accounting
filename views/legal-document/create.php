<?php

use app\models\search\LegalDocumentSearch;

/* @var $this yii\web\View */
/* @var $model app\models\LegalDocument */

$this->title = 'Create Legal Document';
$this->params['breadcrumbs'][] = ['label' => 'Legal Documents', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new LegalDocumentSearch();
?>
<div class="legal-document-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>