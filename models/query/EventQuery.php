<?php

namespace app\models\query;

use app\helpers\App;
use app\models\User;
/**
 * This is the ActiveQuery class for [[\app\models\Event]].
 *
 * @see \app\models\Event
 */
class EventQuery extends ActiveQuery
{
	public function accessible()
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
        	// return $this->innerJoinWith('accountant');
        }

        return $this;
    }

    public function count($q = '*', $db = null)
    {
        $this->accessible();
        return parent::count($q, $db);
    }

    public function all($db = null)
    {
        $this->accessible();
        return parent::all($db);
    }

    public function one($db = null)
    {
        $this->accessible();
        return parent::one($db);
    }

    public function sum($q, $db = null)
    {
        $this->accessible();
        return parent::sum($q, $db);
    }

    public function average($q, $db = null)
    {
        $this->accessible();
        return parent::average($q, $db);
    }

    public function min($q, $db = null)
    {
        $this->accessible();
        return parent::min($q, $db);
    }

    public function max($q, $db = null)
    {
        $this->accessible();
        return parent::max($q, $db);
    }

    public function scalar($db = null)
    {
        $this->accessible();
        return parent::scalar($db);
    }

    public function column($db = null)
    {
        $this->accessible();
        return parent::column($db);
    }

    public function exists($db = null)
    {
        $this->accessible();
        return parent::exists($db);
    }
}