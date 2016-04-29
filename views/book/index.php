<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;
use yii\jui\DatePicker;

?>

<h1>Книги</h1>

<?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>

<?php $form = ActiveForm::begin([
    'id' => 'search-book-form',
    'options' => ['class' => 'form-horizontal user-create-form', 'style' => 'margin-left: 20px;'],
//    'enableAjaxValidation' => true,
]); ?>

<?php echo $form->field($model, 'author_id', ['template' => "{label}<br>{error}{input}"])->dropdownList(
    ArrayHelper::map(Author::find()->asArray()->all(),
        'id',
        function ($data) {
            return $data['firstname'] . ' ' . $data['lastname'];
        }
    ),
    ['prompt' => 'Выберете автора',
        'class' => 'form-control search-form-field'
    ]

);
?>

<?= $form->field($model, 'name', ['options' => ['class' => 'form-group search-form-field']]) ?>

<?= $form->field($model, 'date_from')->widget(DatePicker::classname(),
    ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'search-form-field form-control'], 'clientOptions' => ['changeYear' => true]])
?>

<?= $form->field($model, 'date_before')->widget(DatePicker::classname(),
    ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'search-form-field form-control'], 'clientOptions' => ['changeYear' => true]])
?>

<?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>
<br>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['label' => 'ID', 'attribute' => 'id'],
        ['label' => 'Название', 'attribute' => 'name'],
        ['label' => 'Обложка книги', 'format' => 'raw', 'attribute' => 'preview', 'value' => function($data){
            return $data->preview ? Html::img($data->preview, ['width' => '100px', 'data-lightbox' => 'test12313']) : 'не задано';
        }],
        ['label' => 'Автор', 'attribute' => 'author.fullname'],
        ['attribute' => 'date'],
        ['attribute' => 'date_create'],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Операции',
            'template' => '{delete}{view}{update}',
        ],
    ]
]);
?>