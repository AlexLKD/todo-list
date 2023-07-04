<?php

require 'includes/_database.php';

session_start();

if (!(array_key_exists('HTTP_REFERER', $_SERVER)) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
    header('Location: index.php?msg=error_referer');
    exit;
} else if (!array_key_exists('token', $_SESSION) || !array_key_exists('token', $_REQUEST) || $_SESSION['token'] !== $_REQUEST["token"]) {
    //...
    header('Location: index.php?msg=error_csrf');
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);

$isOk = false;
$status = (int)strip_tags($data['status']);
$taskId = $_GET['validate'];

if ($data['action'] === 'validate' && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $query = $dbCo->prepare("UPDATE task SET status = '2' WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => intval(strip_tags($taskId))
    ]);

    if ($isOk) {
        $query = $dbCo->prepare("SELECT status FROM task WHERE `status` = :status;");
        $isOk = $query->execute([
            'status' => $status
        ]);
        $query->fetchColumn();
    }
}

header('content-type:application/json');
echo json_encode([
    'result' => $isOk,
    'status' => $status
]);
