<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;
use yii\jui\DatePicker;
use \app\assets\LightBoxAsset;
LightBoxAsset::register($this);
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

<?= Html::submitButton('Поиск', ['class' => 'btn btn-primary', 'id' => 'find-book-button']) ?>

<?php ActiveForm::end() ?>
<br>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['label' => 'ID', 'attribute' => 'id'],
        ['label' => 'Название', 'attribute' => 'name'],
        ['label' => 'Обложка книги', 'format' => 'raw', 'attribute' => 'preview', 'value' => function($data){
            return $data->preview ? Html::img($data->preview, ['width' => '100px']) : 'не задано';
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

<!-- Trigger the modal with a button -->
<button id="open-modal" type="button" class="btn btn-info btn-lg display_none" data-toggle="modal" data-target="#modal-window">Open Modal</button>

<!-- Modal -->
<div id="modal-window" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', 'img', function () {
            if($(this).attr("width"))
            {
                $(this).removeAttr("width");
            } else {
                $(this).attr("width", "100px");
            }
        })

        $(document).on('click', 'a[aria-label="View"]', function () {
            $.ajax({
                url: $(this).attr("href"),
                type: 'post',
                success: function (data) {
                    $(".modal-body").html(data);
                    $("#open-modal").click();
                }
            });

            return false;
        });

        $(document).on('click', 'a[aria-label="Update"]', function () {
            $.ajax({
                url: $(this).attr("href"),
                type: 'post',
                success: function (data) {
                    $(".modal-body").html(data);
                    $("#open-modal").click();
                }
            });

            return false;
        });

        $(document).on('submit', '#update-book-form', function (event) {
            var formData = new FormData($(this)[0]);
            console.log(formData);

            event.preventDefault();
            form = $(this);
            if (form.find('.has-error').length) {
                return false;
            }

            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: formData,
                success: function (data) {
                    if (data == 'success') {
                        $("#modal-window .close").click();
                        $("#find-book-button").click();
                    }
                    else {
                        $(".modal-body").html(data);
//                        $(".book-form").html(data);
//                        alert("Something goes wrong");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });
    })

</script>