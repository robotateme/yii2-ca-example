<?php

use yii\db\Migration;

/**
 * Class m220518_145031_alterColumnDeletionInDateTableAdmin
 */
class m220518_145031_alter_column_deletion_date_table_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('admin', 'deletion_date', 'block_date');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('admin', 'block_date', 'deletion_date');

    }
}
