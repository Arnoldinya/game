<?php

use yii\db\Migration;

class m170323_132202_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'email'         => $this->string()->notNull(),
            'balance'       => $this->float()->notNull()->defaultValue(0),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'name'          => 'test',
            'password_hash' => '$2y$13$DUU.GS6KCwMyJPLSmhqci.z1Vyt06bb78db1is47GZnYDogqipwCW',
            'email'         => 'test@test.test',
            'balance'       => '1000',
        ]);

        $this->createTable('log', [
            'id'               => $this->primaryKey(),
            'user_id'          => $this->integer()->notNull(),
            'rate'             => $this->float()->notNull(),
            'gain'             => $this->float()->notNull(),
            'user_position'    => $this->integer()->notNull(),
            'correct_position' => $this->integer()->notNull(),
            'type'             => $this->integer()->notNull(),
            'created_at'       => $this->integer(),
            'updated_at'       => $this->integer(),
        ], $tableOptions);

        $this->createIndex('log_user_id', '{{%log}}', 'user_id');
        $this->addForeignKey('log_user_id', '{{%log}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('pay', [
            'id'               => $this->primaryKey(),
            'user_id'          => $this->integer()->notNull(),
            'value'            => $this->float()->notNull(),
            'created_at'       => $this->integer(),
            'updated_at'       => $this->integer(),
        ], $tableOptions);

        $this->createIndex('pay_user_id', '{{%pay}}', 'user_id');
        $this->addForeignKey('pay_user_id', '{{%pay}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('pay');
        $this->dropTable('log');
        $this->dropTable('user');
    }
}
