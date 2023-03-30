<?php

use yii\db\Migration;

/**
 * Class m220523_202745_addExpirationDateCanExpired
 */
class m220523_202745_add_expiration_date_and_can_expiring extends Migration
{
    public const TABLE = 'admin';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'access_token_expiration_date', $this->dateTime()->null());
        $this->addColumn(self::TABLE, 'access_token_can_expire', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'access_token_expiration_date');
        $this->dropColumn(self::TABLE, 'access_token_can_expire');
    }
}
