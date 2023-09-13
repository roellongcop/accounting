<?php

$this->registerWidgetJs($widgetFunction, <<< JS
	$('.datepicker-{$widgetId}').datepicker({$options});
JS);
?>

<?= $form->field($model, $attribute)->textInput([
	'class' => "form-control datepicker-input datepicker-{$widgetId}",
	'autocomplete' => 'off',
	'readonly' => true,
	'placeholder' => 'Select Date',
	'datepicker-input' => true
]) ?>