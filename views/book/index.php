<?php
/* @var $this yii\web\View */
?>
    <h1>Книги</h1>



<?php

use app\models\Book;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>

<?php
$dataProvider = new ActiveDataProvider([
    'query' => Book::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        ['label' => 'ID', 'attribute' => 'id'],
        ['label' => 'Название', 'attribute' => 'name'],
//        ['label' => 'Код инвайта', 'attribute' => 'preview'],
        ['label' => 'Автор',  'value' => function($data){
            return $data->author->firstname . ' ' . $data->author->lastname;
        }],
        ['attribute' => 'date'],
        ['attribute' => 'date_create'],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Кнопки действий',
            'template' => '{delete}{view}{update}',
        ],
    ]
]);
?>