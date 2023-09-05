<?php

namespace app\tests\fixtures;

class KpiFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Kpi';
    public $dataFile = '@app/tests/fixtures/data/kpi.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}