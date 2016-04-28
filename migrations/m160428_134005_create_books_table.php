<?php

use yii\db\Migration;

class m160428_134005_create_books_table extends Migration
{
    public function up()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'date_create' => $this->dateTime(),
            'date_update' => $this->dateTime(),
            'preview' => $this->string(),
            'date' => $this->date(),
            'author_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-book-author_id', 'book', 'author_id', 'author', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('book');
    }
}
