<?php

/**
 * Handles the creation of table `{{%receivables}}`.
 */
class m231016_145224_create_receivables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%receivables}}';
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