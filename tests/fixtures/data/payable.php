<?php

use app\models\Payable;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'title' => 'Title',
		'due_date' => 'Due Date',
		'description' => 'Description',
		'file_tokens' => 'File Tokens',
		'status' => 'Status',
		'amount' => 'Amount',
		'record_status' => Payable::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Payable::RECORD_INACTIVE
]);

return $model->getData();