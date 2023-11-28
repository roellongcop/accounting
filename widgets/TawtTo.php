<?php

namespace app\widgets;

use app\helpers\App;

class TawtTo extends BaseWidget
{
    public $user;
    public $tawk_to_link;

    public function init()
    {
        // your logic here
        parent::init();

        $this->user = $this->user ?: App::identity();
        $this->tawk_to_link = $this->tawk_to_link ?: App::setting('system')->tawk_to_link;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return;
        if (! App::identity('isClient')) return;
        if (! $this->tawk_to_link) return;

        return $this->render('tawt-to', [
            'user' => $this->user,
            'tawk_to_link' => $this->tawk_to_link,
        ]);
    }
}