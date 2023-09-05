<?php

namespace app\tests\fixtures;

class InventoryFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Inventory';
    public $dataFile = '@app/tests/fixtures/data/inventory.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}