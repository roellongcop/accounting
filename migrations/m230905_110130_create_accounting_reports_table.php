<?php

/**
 * Handles the creation of table `{{%accounting_reports}}`.
 */
class m230905_110130_create_accounting_reports_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%accounting_reports}}';
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