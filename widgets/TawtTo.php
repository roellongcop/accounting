<?php

namespace app\widgets;

use app\helpers\App;

class TawtTo extends BaseWidget
{
    public $user;

    public function init()
    {
        // your logic here
        parent::init();

        $this->user = $this->user ?: App::identity();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (! App::identity('isClient')) return;

        return $this->render('tawt-to', [
            'user' => $this->user
        ]);
    }
}