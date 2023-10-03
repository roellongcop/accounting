<?php

namespace app\tests\fixtures;

class EventFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Event';
    public $dataFile = '@app/tests/fixtures/data/event.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}