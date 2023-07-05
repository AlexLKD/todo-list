<?php
require 'includes/_database.php';
session_start();


$data = json_decode(file_get_contents('php://input'), true);
if (
    !array_key_exists('token', $_SESSION) || !array_key_exists('token', $data)
    || $_SESSION['token'] !== $data['token']
) {
    echo json_encode([
        'result' => 'false',
        'error' => 'Accès refusé, jeton invalide.'
    ]);
    exit;
}
header('content-type:application/json');



// $idTask = (int)strip_tags($data['idTask']);


if ($data['action'] === 'validate' && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $id=intval(strip_tags($data['idTask']));
    $ranking=intval(strip_tags($data['ranking']));
    $query = $dbCo->prepare("UPDATE task SET status = '2'  WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => $id
    ]);
    $queryReplace = $dbCo->prepare("UPDATE task SET ranking = ranking - 1 WHERE ranking > :currentRanking");
    $isOk = $queryReplace->execute([
        ':currentRanking' => $ranking
    ]);
}


$datas =[
    'result' => true,
    'message' => 'Everything is ok',
    'idTask' => $id,
    'token' => $data['token']
];
echo json_encode($datas);



?>