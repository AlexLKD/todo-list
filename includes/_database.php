<?php
try {
    $dbCo = new PDO(
        'mysql:host=localhost;dbname=todo-list;charset=utf8',
        'phplocal',
        'phplocal'
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (Exception $e) {
    die('Unable to connect to the database.
        ' . $e->getMessage());
}
