<?php

use app\helpers\Html;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;
use app\helpers\Url;
use app\models\CashFlow;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CashFlowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expense';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['createButton'] = Html::a('Create', $model->createUrl, [
    'class' => 'btn btn-success font-weight-bolder'
]); 
$this->params['showExportButton'] = true;
$this->params['activeMenuLink'] = Url::toRoute(['cash-flow/expense']);
$this->params['findByKeywordsUrl'] = Url::toRoute(['cash-flow/find-by-keywords', 'type' => CashFlow::TYPE_PAYABLE]);

$this->params['exportOptions'] = [
    'printUrl' => $model->getPrintUrl(false),
    'pdfUrl' => $model->getExportPdfUrl(false),
    'csvUrl' => $model->getExportCsvUrl(false),
    'xlsUrl' => $model->getExportXlsUrl(false),
    'xlsxUrl' => $model->getExportXlsxUrl(false),
];
$this->params['headerButtons'] = Html::a('Import', ['import-expense'], [
    'class' => 'ml-2 btn btn-primary font-weight-bolder',
]);
?>
<div class="cash-flow-index-page">
    <?= FilterColumn::widget([
        'searchModel' => $searchModel,
    ]) ?>
    <?= Html::beginForm(['bulk-action'], 'post'); ?>
        <?= BulkAction::widget(['searchModel' => $searchModel]) ?>
        
        <?= Grid::widget([
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]); ?>
    <?= Html::endForm(); ?> 
</div>