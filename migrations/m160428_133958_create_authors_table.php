<?php

use yii\db\Migration;

class m160428_133958_create_authors_table extends Migration
{
    public function up()
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(),
            'lastname' => $this->string()
        ]);
    }

    public function down()
    {
        $this->dropTable('author');
    }
}
