<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Вас приветствует Bookstore !</h2>

        <p class="lead">Что бы управлять записями книг, зарегестрируйтесь и войдите в систему. </p>
        <?= Html::img('images/books.jpg')?>
        <p><a class="btn btn-lg btn-success" href="site/register">Зарегистрироваться !</a></p>
    </div>


</div>
