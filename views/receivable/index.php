<?php

use app\helpers\Html;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ReceivableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receivables';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>
<div class="receivable-index-page">
  <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
  
  <?= Grid::widget([
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
  ]); ?>
</div>