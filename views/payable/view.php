<?php

use app\widgets\Anchors;
use app\models\search\PayableSearch;
use app\widgets\Detail;
use app\widgets\DataTable;
use app\widgets\Timeline;
use app\widgets\PaymentButton;

/* @var $this yii\web\View */
/* @var $model app\models\Payable */

$this->title = 'Payable: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Payables', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new PayableSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false; 

$this->registerCss(<<< CSS
  .detail-view {
    margin-top: 0 !important;
  }
CSS);
?>
<div class="payable-view-page">
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
    <?= DataTable::widget(['models' => $model->files, 'pageLength' => 3]) ?>
  <?php $this->endContent() ?>
</div>