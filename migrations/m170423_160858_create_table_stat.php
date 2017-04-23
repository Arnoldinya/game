<?php

use yii\db\Migration;

class m170423_160858_create_table_stat extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('stat', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'cnt'        => $this->integer()->notNull()->defaultValue(0),
            'value'      => $this->float()->notNull()->defaultValue(0),
            'is_current' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('stat_is_current', '{{%stat}}', 'is_current');
        $this->createIndex('stat_user_id', '{{%stat}}', 'user_id');
        $this->addForeignKey('stat_user_id', '{{%stat}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('pay');
    }
}
