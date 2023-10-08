<?php

namespace app\tests\fixtures;

class ReceivableFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Receivable';
    public $dataFile = '@app/tests/fixtures/data/receivable.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}