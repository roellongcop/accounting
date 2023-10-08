<?php

/**
 * Handles adding columns to table `{{%payables}}`.
 */
class m231021_095502_add_columns_to_payables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%payables}}';
    }

    public function columns()
    {
        return [
            'amount_paid' => $this->decimal(11, 2)->notNull()->defaultValue(0),
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
