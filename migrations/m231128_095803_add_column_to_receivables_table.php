<?php

/**
 * Handles adding columns to table `{{%receivables}}`.
 */
class m231128_095803_add_column_to_receivables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%receivables}}';
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
