<?php

/**
 * Handles adding columns to table `{{%events}}`.
 */
class m231007_171510_add_columns_to_events_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%events}}';
    }

    public function columns()
    {
        return [
            'color' => $this->string(8)->notNull(),
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
