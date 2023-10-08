<?php

use app\helpers\Html;
use app\helpers\Url;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CashFlowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Income';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['createButton'] = Html::a('Create', $model->createUrl, [
    'class' => 'btn btn-success font-weight-bolder'
]); 
$this->params['showExportButton'] = true;
$this->params['activeMenuLink'] = Url::toRoute(['cash-flow/income']);
$this->params['findByKeywordsUrl'] = $model->findByKeywordsUrl;
$this->params['exportOptions'] = [
    'printUrl' => $model->getPrintUrl(false),
    'pdfUrl' => $model->getExportPdfUrl(false),
    'csvUrl' => $model->getExportCsvUrl(false),
    'xlsUrl' => $model->getExportXlsUrl(false),
    'xlsxUrl' => $model->getExportXlsxUrl(false),
];
?>

<div class="cash-flow-index-page">
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['bulk-action'], 'post'); ?>
        <?= BulkAction::widget(['searchModel' => $searchModel]) ?>
        
        <?= Grid::widget([
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]); ?>
    <?= Html::endForm(); ?> 
</div>