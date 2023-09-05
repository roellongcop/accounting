<?php

/**
 * Handles the creation of table `{{%cash_flows}}`.
 */
class m230905_110730_create_cash_flows_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%cash_flows}}';
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