<?php


use app\widgets\FileExplorer;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BirFillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BIR Fillings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bir-filling-index-page">
    <?= FileExplorer::widget([
        'tag' => 'BIR Filling',
        'breadcrumbs' => [['folderName' => 'BIR Filling', 'folderPath' => '']],
    ]) ?>
</div>