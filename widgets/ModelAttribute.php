<?php

namespace app\widgets;

class ModelAttribute extends BaseWidget
{
    public $model;
    public $attribute;
    public $content;
    public $header;
    public $default = '-';

    public function init()
    {
        parent::init();

        if (!$this->header && $this->model && $this->attribute) {
            $this->header = $this->model->getAttributeLabel($this->attribute);
        }

        if (!$this->content && $this->model && $this->attribute) {
            $this->content = $this->model->{$this->attribute};
        }

        $this->content = $this->content !== null ? $this->content: $this->default;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('model-attribute', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'header' => $this->header,
            'content' => $this->content,
        ]);
    }
}