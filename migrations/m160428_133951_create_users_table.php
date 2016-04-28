<?php

use yii\db\Migration;

class m160428_133951_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(20),
            'password_hash' => $this->string(60),
            'auth_key' => $this->string(32),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
