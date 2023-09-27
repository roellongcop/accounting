<?php

namespace app\commands\seeder;

use app\commands\models\CashFlow;
use app\commands\models\User;
use app\commands\models\Role;
use yii\helpers\Inflector;

class CashFlowSeeder extends Seeder
{
	public $modelClass = 'app\commands\models\CashFlow';
	public $users;

	public function __construct()
	{
		parent::__construct();
		$this->users = array_keys(User::dropdown('id', 'email', [
			'role_id' => Role::CLIENT
		]));
	}

	public function attributes()
	{
		$created_at = $this->created_at();
		$name = $this->faker->firstName;

		$year = date('Y');
		$start = strtotime("{$year}-01-01");
	    $end = strtotime("{$year}-12-31");

	    $randomTimestamp = mt_rand($start, $end);

	    $date = date('Y-m-d', $randomTimestamp);

		return [
			'user_id' => $this->faker->randomElement($this->users),
			'amount' => $this->faker->randomNumber(5, false),
			'name' => $name,
			'date' => $date,
			'description' => $this->faker->text,
			'type' => $this->faker->randomElement([
				CashFlow::TYPE_PAYABLE,
				CashFlow::TYPE_RECEIVABLE,
			]),
			'status' => $this->faker->randomElement([
				CashFlow::STATUS_PENDING,
				CashFlow::STATUS_COMPLETED,
			]),
			'record_status' => CashFlow::RECORD_ACTIVE,
			'created_at' => $created_at,
			'updated_at' => $created_at,
		];
	}
}