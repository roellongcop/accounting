<?php

namespace app\models\query;

use app\models\ActiveRecord;
use app\models\User;
use app\helpers\App;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    public function available()
    {
        return $this->andWhere([
            $this->field('record_status') => ActiveRecord::RECORD_ACTIVE,
            $this->field('status') => User::STATUS_ACTIVE,
            $this->field('is_blocked') => User::UNBLOCKED,
        ]);
    }

    public function myClient()
    {
        if (App::identity('isAdmin')) {
            return $this->andFilterWhere([
                $this->field('accountant_id') => App::identity('id')
            ]);
        }

        return $this;
    }

    public function count($q = '*', $db = null)
    {
        $this->myClient();
        return parent::count($q, $db);
    }

    public function all($db = null)
    {
        $this->myClient();
        return parent::all($db);
    }

    public function one($db = null)
    {
        $this->myClient();
        return parent::one($db);
    }

    public function sum($q, $db = null)
    {
        $this->myClient();
        return parent::sum($q, $db);
    }

    public function average($q, $db = null)
    {
        $this->myClient();
        return parent::average($q, $db);
    }

    public function min($q, $db = null)
    {
        $this->myClient();
        return parent::min($q, $db);
    }

    public function max($q, $db = null)
    {
        $this->myClient();
        return parent::max($q, $db);
    }

    public function scalar($db = null)
    {
        $this->myClient();
        return parent::scalar($db);
    }

    public function column($db = null)
    {
        $this->myClient();
        return parent::column($db);
    }

    public function exists($db = null)
    {
        $this->myClient();
        return parent::exists($db);
    }
}