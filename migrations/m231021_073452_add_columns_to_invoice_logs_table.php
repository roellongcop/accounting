<?php

/**
 * Handles adding columns to table `{{%invoice_logs}}`.
 */
class m231021_073452_add_columns_to_invoice_logs_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%invoice_logs}}';
    }

    public function columns()
    {
        return [
            'file_tokens' => $this->text()
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
