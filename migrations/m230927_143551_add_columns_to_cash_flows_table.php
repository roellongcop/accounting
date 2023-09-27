<?php

/**
 * Handles adding columns to table `{{%cash_flows}}`.
 */
class m230927_143551_add_columns_to_cash_flows_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%cash_flows}}';
    }

    public function columns()
    {
        return [
            'type' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'amount' => $this->decimal(11, 2)->notNull()->defaultValue(0),
            'date' => $this->string(16)->notNull(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
        ];

        // FOR SETTING utf
        // ->append('CHARACTER SET utf8 COLLATE utf8mb4_unicode_520_ci')
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
