<?php


use app\widgets\FileExplorer;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payrol-index-page">
    <?= FileExplorer::widget([
        'tag' => 'Payroll',
        'breadcrumbs' => [['folderName' => 'Payroll', 'folderPath' => '']],
    ]) ?>
</div>