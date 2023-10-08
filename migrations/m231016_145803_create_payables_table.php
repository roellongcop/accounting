<?php

/**
 * Handles the creation of table `{{%payables}}`.
 */
class m231016_145803_create_payables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%payables}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'title' => $this->string()->notNull(),
            'due_date' => $this->string()->notNull(),
            'description' => $this->text(),
            'file_tokens' => $this->text(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'amount' => $this->decimal(11, 2)->notNull()->defaultValue(0),
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}