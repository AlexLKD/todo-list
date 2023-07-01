<?php
require 'vendor/autoload.php';
<<<<<<< HEAD


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $dbCo = new PDO(

        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD'],
=======
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
try {
    $dbCo = new PDO(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
        // 'mysql:host=localhost;dbname=todo_list;charset=utf8',
        // 'phplocal',
        // 'phplocal'
>>>>>>> 106e22a8ec6483c85d10fe2c1771d6b5d5af05b7
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (Exception $e) {
    die('Unable to connect to the database.
        ' . $e->getMessage());
}
