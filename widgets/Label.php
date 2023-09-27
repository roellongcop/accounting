<?php

namespace app\widgets;

class Label extends BaseWidget
{
    public $options;
    public $is_badge = true;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!$this->is_badge) return $this->options['label'] ?? '';

        return $this->render('label', [
            'options' => $this->options
        ]);
    }
}