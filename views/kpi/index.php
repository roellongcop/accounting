<?php


use app\widgets\FileExplorer;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\KpiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'KPI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="legal-document-index-page">
    <?= FileExplorer::widget([
        'tag' => 'KPI',
        'breadcrumbs' => [['folderName' => 'KPI', 'folderPath' => '']],
    ]) ?>
</div>