<?php

use yii\db\Migration;

/**
 * Class m231109_132922_alter_column_to_roles_table
 */
class m231109_132922_alter_column_to_roles_table extends Migration
{
    public function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->tableName(), 'main_navigation', 'MEDIUMTEXT');
        $this->alterColumn($this->tableName(), 'module_access', 'MEDIUMTEXT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableName(), 'main_navigation', $this->text());
        $this->alterColumn($this->tableName(), 'module_access', $this->text());
    }
}
