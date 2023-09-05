<?php

/**
 * Handles the creation of table `{{%legal_documents}}`.
 */
class m230905_110229_create_legal_documents_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%legal_documents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'slug' => $this->string(),
            'files' => $this->text(),
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