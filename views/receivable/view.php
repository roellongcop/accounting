<?php

use app\widgets\Anchors;
use app\models\search\ReceivableSearch;
use app\widgets\Detail;
use app\widgets\DataTable;
use app\widgets\Timeline;
use app\widgets\PaymentButton;

/* @var $this yii\web\View */
/* @var $model app\models\Receivable */

$this->title = 'Receivable: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Receivables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ReceivableSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false; 

$this->registerCss(<<< CSS
  .detail-view {
    margin-top: 0 !important;
  }
CSS);
?>
<div class="receivable-view-page">
  <?= Anchors::widget([
    'names' => ['update', 'duplicate', 'delete', 'log'], 
    'model' => $model
  ]) ?> 
  <?= PaymentButton::widget(['model' => $model]) ?>
  <div class="row mt-5">
    <div class="col-md-6">
      <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
        'title' => 'PRIMARY INFORMATION',
        'stretch' => true,
      ]) ?>
        <?= Detail::widget(['model' => $model]) ?>
      <?php $this->endContent() ?>
    </div>
    <div class="col-md-6">
      <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
        'title' => 'INVOICE LOGS',
        'stretch' => true,
      ]) ?>
        <?= Timeline::widget(['data' => $model->invoiceLogs]) ?>
      <?php $this->endContent() ?>
    </div>
  </div>
  
  <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
    'title' => 'FILES',
  ]) ?>
    <?= DataTable::widget(['models' => $model->files, 'pageLength' => 10]) ?>
  <?php $this->endContent() ?>
</div>