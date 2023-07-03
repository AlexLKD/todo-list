<?php
require 'vendor/autoload.php';
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
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (Exception $e) {
    die('Unable to connect to the database.
        ' . $e->getMessage());
}
