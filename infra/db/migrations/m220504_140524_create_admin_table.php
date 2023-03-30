<?php

use yii\db\Migration;

class m220504_140524_create_admin_table extends Migration
{
    public const TABLE = 'admin';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->string(32)->notNull()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'login' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'role' => $this->integer()->notNull(),
            'first_name' => $this->string(255)->notNull(),
            'last_name' => $this->string(255)->notNull(),
            'middle_name' => $this->string(255)->null(),
            'is_blocked' => $this->boolean()->notNull(),
            'creation_date' => $this->timestamp()->notNull(),
            'deletion_date' => $this->timestamp()->null(),
            'last_update_date' => $this->timestamp()->null(),
            'last_login_date' => $this->timestamp()->null(),
            'access_token' => $this->string(255)->null()
        ]);

        $this->addPrimaryKey('pk_' . self::TABLE, self::TABLE, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
