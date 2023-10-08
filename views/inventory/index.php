<?php


use app\widgets\FileExplorer;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventory';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-index-page">
    <?= FileExplorer::widget([
        'tag' => 'Inventory',
        'breadcrumbs' => [['folderName' => 'Inventory', 'folderPath' => '']],
    ]) ?>
</div>