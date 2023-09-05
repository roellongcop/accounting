<?php

/**
 * Handles the creation of table `{{%inventories}}`.
 */
class m230905_110756_create_inventories_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%inventories}}';
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