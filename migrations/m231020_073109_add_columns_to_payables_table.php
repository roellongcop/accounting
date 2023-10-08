<?php

/**
 * Handles adding columns to table `{{%payables}}`.
 */
class m231020_073109_add_columns_to_payables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%payables}}';
    }

    public function columns()
    {
        return [
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumns($this->tableName(), $this->columns());
        
        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumns($this->tableName(), $this->columns());
    }
}
