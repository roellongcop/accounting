<?php

namespace app\tests\fixtures;

class LegalDocumentFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\LegalDocument';
    public $dataFile = '@app/tests/fixtures/data/legal-document.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}