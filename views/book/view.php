<?php
use yii\helpers\Html;

?>

<div class="book-form">
    <div>
        <?php if($model->preview): ?>
            <?= Html::img($model->preview, ['width' => '200px']) ?>
        <?php endif; ?>
    </div>

    <div>
        <table class="table" style="display: block; margin-top: 20px;">
            <tr><td>Название</td><td><?= $model->name ?></td></tr>
            <tr><td>Автор</td><td><?= $model->author->firstname . ' ' . $model->author->lastname; ?></td></tr>
            <tr><td>Дата публикации</td><td><?= $model->date ?></td></tr>
            <tr><td>Добавлено</td><td> <?= $model->date_create ?></td></tr>
            <tr><td>Последнее редактирование</td><td><?= $model->date_update ?></td></tr>
        </table>
    </div>
</div>