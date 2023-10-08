<?php

/**
 * Handles adding columns to table `{{%cash_flows}}`.
 */
class m231008_134346_add_columns_to_cash_flows_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%cash_flows}}';
    }

    public function columns()
    {
        return [
            'biller' => $this->string()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumns($this->tableName(), $this->columns());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumns($this->tableName(), $this->columns());
    }
}
