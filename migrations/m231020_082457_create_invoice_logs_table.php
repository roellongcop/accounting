<?php

/**
 * Handles the creation of table `{{%invoice_logs}}`.
 */
class m231020_082457_create_invoice_logs_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%invoice_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'type' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'remarks' => $this->text(),
            'model_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'model_id' => 'model_id',
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