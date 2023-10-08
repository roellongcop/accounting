<?php

namespace app\tests\fixtures;

class PayableFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Payable';
    public $dataFile = '@app/tests/fixtures/data/payable.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}