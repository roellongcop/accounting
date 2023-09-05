<?php

/**
 * Handles the creation of table `{{%b_i_r_fillings}}`.
 */
class m230905_110214_create_bir_fillings_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%bir_fillings}}';
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