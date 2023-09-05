<?php

namespace app\tests\fixtures;

class PayrollFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Payroll';
    public $dataFile = '@app/tests/fixtures/data/payroll.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}