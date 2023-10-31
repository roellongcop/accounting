<?php

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m231111_042000_add_column_to_users_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%users}}';
    }

    public function columns()
    {
        return [
            'module_access' => 'MEDIUMTEXT'
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
