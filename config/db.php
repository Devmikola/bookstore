<?php

if(getenv("YII_ENV") == 'prod')
{
    $clearDB = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $clearDB["host"];
    $username = $clearDB["user"];
    $password = $clearDB["pass"];
    $db = substr($clearDB["path"], 1);
    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$server;port=".$clearDB["port"]."dbname=$db",
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8',
    ];
} else {
    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=bookstore',
        'username' => 'root',
        'password' => '9379992',
        'charset' => 'utf8',
    ];
}


return $ret_arr;