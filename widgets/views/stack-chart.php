<?php

use app\helpers\App;
use yii\helpers\ArrayHelper;
use app\helpers\Html;

$this->registerWidgetCssFile('stack-chart');
$this->registerWidgetJsFile('stack-chart');

$this->registerJs(<<< JS
  new StackChartWidget({
    widgetId: '{$widgetId}',
    dataUrl: '{$data_url}',
    dateRange: '{$date_range}',
    userId: {$user_id},
    additionalScripts: (stackChart) => {
      {$additional_scripts}
    }
  }).init();
JS);
?>

<div class="stack-chart" id="<?= $widgetId ?>-stack-chart">
  <div id="<?= $widgetId ?>"></div>

  <div class="px-5 mb-5 d-flex justify-content-between">
    <div class="btn-group">
      <a href="#" class="btn btn-outline-secondary btn-icon btn-prev">
        <i class="fa fa-angle-left"></i>
      </a>
      <a href="#" class="btn btn-outline-secondary btn-icon btn-next">
        <i class="fa fa-angle-right"></i>
      </a>
    </div>
    <a href="#" class="btn btn-outline-secondary btn-year font-weight-bold border-0">
    </a>
  </div>
</div>