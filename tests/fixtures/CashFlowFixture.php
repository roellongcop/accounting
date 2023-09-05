<?php

namespace app\tests\fixtures;

class CashFlowFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\CashFlow';
    public $dataFile = '@app/tests/fixtures/data/cash-flow.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}