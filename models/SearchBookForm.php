<?php
namespace app\models;

use yii\base\Model;

class SearchBookForm extends Model
{
    public $author_id;
    public $name;
    public $date_from;
    public $date_before;

    public function attributeLabels()
    {
        return [
            'author_id' => 'Автор',
            'name' => 'Название книги',
            'date_from' => 'Дата выхода книги',
            'date_before' => 'До',
        ];
    }

    public function rules()
    {
        return [
            [['author_id', 'name', 'date_from', 'date_before'], 'safe']
        ];
    }

}