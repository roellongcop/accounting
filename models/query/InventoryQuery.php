<?php

namespace app\models\query;

use app\helpers\App;
use app\models\User;

/**
 * This is the ActiveQuery class for [[\app\models\Inventory]].
 *
 * @see \app\models\Inventory
 */
class InventoryQuery extends ActiveQuery
{
	public function client()
	{
		if (App::identity('isClient')) {
			return $this->andFilterWhere([
				$this->field('user_id') => App::identity('id')
			]);
		}

        if (App::identity('isAdmin')) {
            return $this->andFilterWhere([
                $this->field('user_id') => User::find()
                    ->select('id')
                    ->where(['accountant_id' => App::identity('id')])
            ]);
        }

		return $this;
	}

	public function count($q = '*', $db = null)
    {
        $this->client();
        return parent::count($q, $db);
    }

    public function all($db = null)
    {
        $this->client();
        return parent::all($db);
    }

    public function one($db = null)
    {
        $this->client();
        return parent::one($db);
    }

    public function sum($q, $db = null)
    {
        $this->client();
        return parent::sum($q, $db);
    }

    public function average($q, $db = null)
    {
        $this->client();
        return parent::average($q, $db);
    }

    public function min($q, $db = null)
    {
        $this->client();
        return parent::min($q, $db);
    }

    public function max($q, $db = null)
    {
        $this->client();
        return parent::max($q, $db);
    }

    public function scalar($db = null)
    {
        $this->client();
        return parent::scalar($db);
    }

    public function column($db = null)
    {
        $this->client();
        return parent::column($db);
    }

    public function exists($db = null)
    {
        $this->client();
        return parent::exists($db);
    }
}