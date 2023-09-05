<?php

use app\models\Payroll;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'name' => 'Name',
		'description' => 'Description',
		'files' => 'Files',
		'record_status' => Payroll::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Payroll::RECORD_INACTIVE
]);

return $model->getData();