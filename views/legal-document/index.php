<?php


use app\widgets\FileExplorer;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LegalDocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Legal Document';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bir-filling-index-page">
    <?= FileExplorer::widget([
        'tag' => 'Legal Document',
        'breadcrumbs' => [['folderName' => 'Legal Document', 'folderPath' => '']],
    ]) ?>
</div>