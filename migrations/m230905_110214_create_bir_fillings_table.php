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
            'file_tokens' => $this->text(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}