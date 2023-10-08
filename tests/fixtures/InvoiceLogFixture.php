<?php

namespace app\tests\fixtures;

class InvoiceLogFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\InvoiceLog';
    public $dataFile = '@app/tests/fixtures/data/invoice-log.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}