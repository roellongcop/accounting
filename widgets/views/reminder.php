<?php

use app\helpers\Html;

$this->registerWidgetCssFile('reminder');
$this->registerWidgetJsFile('reminder');

$this->registerJs(<<< JS
    new ReminderWidget({widgetId: '{$widgetId}'}).init();
JS);
?>

<div class="app-alert <?= $type ?>-alert" id="<?= $widgetId ?>">
    <div>
        <div class="head-alert">
            <?= $icon ?>
            <?= $head ?>
        </div>
        <p class="content-alert">
            <?= $message ?>
        </p>
    </div>
    <?= Html::if($withClose, '<div class="close-alert"> <i class="ki ki-close"></i> </div>') ?>
</div>
