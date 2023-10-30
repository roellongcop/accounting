<?php

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m231030_122146_add_columns_to_users_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%users}}';
    }

    public function columns()
    {
        return [
            'login_type' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'google2fa' => $this->string(),
            'google2fa_ts' => $this->bigInteger(20)->notNull()->defaultValue(0)
        ];

        // FOR SETTING utf
        // ->append('CHARACTER SET utf8 COLLATE utf8mb4_unicode_520_ci')
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
