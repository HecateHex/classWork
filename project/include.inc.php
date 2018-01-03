<?php

include "vendor/autoload.php";
(new Dotenv\Dotenv(__DIR__))->load();
$db = new PDO(
    'mysql:host=' . getenv('DB_HOSTNAME') . ';dbname=' . getenv('DB_DATABASE'),
    getenv('DB_USERNAME'), getenv('DB_PASSWORD'),
    [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4']
);
session_start();

$templates = new \League\Plates\Engine(__DIR__.'/templates');
$templates -> loadExtension(new \League\Plates\Extension\URI($_SERVER['REQUEST_URI']));