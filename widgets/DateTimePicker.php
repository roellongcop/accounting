<?php

namespace app\widgets;

class DateTimePicker extends BaseWidget
{
    public $form;
    public $model;
    public $attribute;
    public $options = [];

    public function init()
    {
        parent::init();

        if ($this->model->{$this->attribute}) {
            $this->model->{$this->attribute} = date('m/d/Y h:i A', strtotime($this->model->{$this->attribute}));
        }
    }
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('date-time-picker', [
            'form' => $this->form,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => json_encode($this->options),
        ]);
    }
}
