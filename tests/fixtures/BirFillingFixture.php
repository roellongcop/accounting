<?php

namespace app\tests\fixtures;

class BirFillingFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\BirFilling';
    public $dataFile = '@app/tests/fixtures/data/bir-filling.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}