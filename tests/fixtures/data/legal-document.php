<?php

use app\models\LegalDocument;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'name' => 'Name',
		'description' => 'Description',
		'files' => 'Files',
		'record_status' => LegalDocument::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => LegalDocument::RECORD_INACTIVE
]);

return $model->getData();