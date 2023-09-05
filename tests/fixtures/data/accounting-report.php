<?php

use app\models\AccountingReport;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'name' => 'Name',
		'description' => 'Description',
		'files' => 'Files',
		'record_status' => AccountingReport::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => AccountingReport::RECORD_INACTIVE
]);

return $model->getData();