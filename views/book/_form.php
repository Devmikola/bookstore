<?php

use yii\helpers\Html;
use app\models\Author;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>

    <?php echo $form->field($model, 'author_id')->dropdownList(
        ArrayHelper::map(Author::find()->asArray()->all(),
            'id',
            function($model) {
                return $model['firstname'].' '.$model['lastname'];
            }
        ),
        ['prompt' => 'Выберете автора']
    );?>

    <?= $form->field($model, 'preview') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>