<?php

namespace app\tests\fixtures;

class AccountingReportFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\AccountingReport';
    public $dataFile = '@app/tests/fixtures/data/accounting-report.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}