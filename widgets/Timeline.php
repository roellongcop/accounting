<?php

namespace app\widgets;

class Timeline extends BaseWidget
{
    public $data;

    public function run()
    {
        return $this->render("timeline", [
            'data' => $this->data
        ]);
    }
}
