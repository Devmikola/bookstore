<?php

use yii\helpers\Html;
use app\models\Author;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

use app\assets\AppAsset;

AppAsset::register($this);
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['id' => $model->isNewRecord ? 'create-book-form' : 'update-book-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php if($model->preview): ?>
        <?= Html::img($model->preview, ['width' => '200px', 'data-lightbox' => 'test12313']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(),
        [   'dateFormat' => 'yyyy-MM-dd',
            'language' => 'ru',
            'options' => ['class' => 'form-control'],
            'clientOptions' => ['changeYear' => true, 'yearRange' => "-120:+0"]
        ])
    ?>

    <?php echo $form->field($model, 'author_id')->dropdownList(
        ArrayHelper::map(Author::find()->asArray()->all(),
            'id',
            function($model) {
                return $model['firstname'].' '.$model['lastname'];
            }
        ),
        ['prompt' => 'Выберете автора']
    );?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>