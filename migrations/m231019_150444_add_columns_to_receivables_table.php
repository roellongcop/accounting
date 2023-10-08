<?php

/**
 * Handles adding columns to table `{{%receivables}}`.
 */
class m231019_150444_add_columns_to_receivables_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%receivables}}';
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
