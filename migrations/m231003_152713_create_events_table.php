<?php

/**
 * Handles the creation of table `{{%events}}`.
 */
class m231003_152713_create_events_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%events}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'start' => $this->string(),
            'end' => $this->string(),
            'slug' => $this->string(),
            'file_tokens' => $this->text(),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'one_day' => $this->smallInteger(2)->notNull()->defaultValue(0),
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