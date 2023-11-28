<?php

/**
 * Handles adding columns to table `{{%payables}}`.
 */
class m231128_100053_add_column_to_payables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%payables}}';
    }

    public function columns()
    {
        return [
            'invoice_date' => $this->string(16)->notNull(),
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
