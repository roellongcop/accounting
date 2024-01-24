<?php

namespace app\widgets;

use app\helpers\App;

class PaymentButton extends BaseWidget
{
    public $model;
    public $buttonOptions = [
        'type' => 'button',
        'class' => 'btn btn-primary',
        'data-toggle' => 'modal',
    ];
    public $buttonLabel = 'Make Payment';

    public function init()
    {
        parent::init();
        $this->buttonOptions['data-target'] = "#staticBackdrop-{$this->id}";
        $this->buttonOptions['id'] = "payment-btn-modal-{$this->id}";
    }

    public function run()
    {
        if (!App::identity()->can('receive-payment', $this->model->controllerID())) return;

        if ($this->model->amount_paid >= $this->model->amount ) return "Payment Complete";

        return $this->render("payment-button", [
            'model' => $this->model,
            'buttonOptions' => $this->buttonOptions,
            'buttonLabel' => $this->buttonLabel,
        ]);
    }
}