<?php

/**
 * Handles adding columns to table `{{%receivables}}`.
 */
class m231021_060649_add_columns_to_receivables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%receivables}}';
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
