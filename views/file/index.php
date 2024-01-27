<?php

use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;
use app\helpers\Html;
use app\helpers\Url;
use app\helpers\App;
use app\models\File;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
$this->params['activeMenuLink'] = Url::toRoute(['file/index']);
?>
 
<div class="file-index-page">
    <div class="lead mb-1 font-weight-bold">
        Total: <?= App::formatter('asFileSize', File::total()) ?>
    </div>
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['bulk-action'], 'post'); ?>
	<?= BulkAction::widget(['searchModel' => $searchModel]) ?>
    <?= Grid::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'paramName' => 'token',
        'template' => ['view', 'delete', 'download'],
    ]); ?>
    <?= Html::endForm(); ?> 
</div>
