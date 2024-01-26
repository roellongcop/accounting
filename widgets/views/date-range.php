<?php

$this->registerWidgetJsFile('date-range');

$this->registerJs( <<< JS
    new DateRangeWidget({
        start: '{$start}',
        end: '{$end}',
        all_start: '{$all_start}',
        all_end: '{$all_end}',
        ranges: {$ranges},
        widgetId: '{$widgetId}',
        time_picker: {$time_picker},
        onChange: ({start, end, label, inputValue}) => {
            {$onChange}
        }
    }).init();
JS);
?>
<?= $header ? $header: <<< HTML
    <br> <p class="font-weight-bold">{$title}</p>
HTML ?>
<div class="date-range-search" id="<?= $widgetId ?>">
    <input name="<?= $name ?>" class="form-control pointer"  readonly placeholder="Select Date" type="hidden"  />
    <span class="form-control pointer"> </span>
</div>