<?php

session_start();
if (!(array_key_exists('HTTP_REFERER', $_SERVER)) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
    header('Location: index.php?msg=error_referer');
    exit;
} else if (!array_key_exists('token', $_SESSION) || !array_key_exists('token', $_REQUEST) || $_SESSION['token'] !== $_REQUEST["token"]) {
    //...
    header('Location: index.php?msg=error_csrf');
    exit;
}

require 'includes/_database.php';
session_start();

// $_SESSION;

// $isOk = false;
if (!(array_key_exists('HTTP_REFERER', $_SERVER)) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
    header('Location: index.php?msg=error_referer');
    exit;
} else if (!array_key_exists('token', $_SESSION) || !array_key_exists('token', $_REQUEST) || $_SESSION['token'] !== $_REQUEST["token"]) {
    //...
    header('Location: index.php?msg=error_csrf');
    exit;
}


// if(!str_contains($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_ORIGIN'])) && str_contains($_SERVER['HTTP_REFERER'], 'http://localhost/intro-php'){
//     header('localisation: index.php?msg=error_referer');
//     exit;
// }
// if($_REQUEST['action'] === 'add' && $_SERVER['REQUEST_METHOD'] == 'POST'){

// }
// SUBMIT TASK
if (isset($_POST['submit'])) {
    $queryPriority = $dbCo->prepare('SELECT MAX(ranking) + 1 AS newPriority FROM task');
    $isOk = $queryPriority->execute();
    $result = $queryPriority->fetch();
    // -----

    $task = $_POST['task'];
    $dateCreate = date('Y-m-d H:i:s');
    $newDate = $_POST['new_date'];
    $query = $dbCo->prepare("INSERT INTO task (text, date_create, ranking, recall) VALUES (:text, :date_create, :ranking, :newDate)");
    $isOk = $query->execute([
        ':text' => strip_tags($task),
        ':date_create' => $dateCreate,
        ':ranking' => intval($result['newPriority']),
        ':newDate' => $newDate
    ]);
    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été ajoutée' : 'Un problème a été rencontré lors de l\'ajout de la tâche'));
    exit;
}
// message if task is submit
if (array_key_exists('task', $_POST)) {
    // echo '<p class="transition" id="message"> La tâche a été ajoutée. </p>';
};

//-----------------------------------------------------------

// DELETE TASK
if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    $query = $dbCo->prepare("DELETE FROM task WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => intval(strip_tags($taskId))
    ]);
    $ranking = $_GET['rank'];
    $queryReplace = $dbCo->prepare("UPDATE task SET ranking = ranking - 1 WHERE ranking > :currentRanking");
    $isOk = $queryReplace->execute([
        ':currentRanking' => intval(strip_tags($ranking))
    ]);
    // message if task is deleted
    if ($query->rowCount()) {
        // echo '<p class="transition" id="message"> La tâche a été supprimée.</p>';
    };
    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été supprimée' : 'La tâche n\'a pas pu être supprimée'));
    exit;
}

//-----------------------------------------------------------

// // VALIDATE TASK
// if (isset($_GET['validate'])) {
//     // $taskId = $_GET['validate'];
//     // $query = $dbCo->prepare("UPDATE task SET status = '2' WHERE Id_task = :taskId");
//     // $isOk = $query->execute([
//     //     ':taskId' => intval(strip_tags($taskId))
//     // ]);
//     $ranking = $_GET['rank'];
//     $queryReplace = $dbCo->prepare("UPDATE task SET ranking = ranking - 1 WHERE ranking > :currentRanking");
//     $isOk = $queryReplace->execute([
//         ':currentRanking' => strip_tags(intval($ranking))
//     ]);
//     // message if task is validated
//     if ($query->rowCount()) {
//         // echo '<p class="transition" id="message"> La tâche a été validée. </p>';
//     };
//     header('Location: index.php?msg=' . ($isOk ? 'La tâche a été validée' : 'Un problème est survenu lors de la validation'));
//     exit;
// }

//-----------------------------------------------------------

// INVALIDATE TASK
if (isset($_GET['invalidate'])) {
    $taskId = $_GET['invalidate'];
    $query = $dbCo->prepare("UPDATE task SET status = '1' WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => intval(strip_tags($taskId))
    ]);

    $ranking = $_GET['rank'];
    $taskId = $_GET['invalidate'];
    $queryReplace = $dbCo->prepare("UPDATE task SET ranking = ranking + 1 WHERE ranking >= :currentRanking AND NOT Id_task = :id");
    $isOk = $queryReplace->execute([
        ':currentRanking' => intval(strip_tags($ranking)),
        ':id' => intval(strip_tags($taskId))
    ]);
    // message if task is invalidated
    if ($query->rowCount()) {
        // echo '<p class="transition" id="message"> La tâche a été invalidée. </p>';
    };
    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été invalidée' : 'La tâche est toujours validée'));
    exit;
}

//-----------------------------------------------------------

// UPDATE TASK
if (isset($_POST['update'])) {
    $taskId = $_POST['update'];
    $newTask = $_POST['new_task'];
    $newDate = $_POST['new_date'];
    $query = $dbCo->prepare("UPDATE task SET text = :newTask, recall = :newDate WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':newTask' => strip_tags($newTask),
        ':newDate' => strip_tags($newDate),
        ':taskId' => intval(strip_tags($taskId))
    ]);
    if ($query->rowCount()) {
    }
    header("Location: index.php?msg=" . ($isOk ? 'Tâche mise à jour' : 'Impossible de mettre à jour'));
    exit;
}


//-----------------------------------------------------------

$rankingPlus = $_GET['rank'] + 1;
$rankingMinus = $_GET['rank'] - 1;
$ranking = $_GET['rank'];

if (array_key_exists('rank', $_GET) && $_GET['prior'] == 'down') {
    $query1 = $dbCo->prepare("UPDATE task SET ranking = ranking - 1 WHERE ranking = :rank");
    $isOk1 = $query1->execute([
        "rank" => intval(strip_tags($ranking))
    ]);

    $query2 = $dbCo->prepare("UPDATE task SET ranking = ranking + 1 WHERE ranking = :rankMinus AND NOT Id_task = :id");
    $isOk2 = $query2->execute([
        "rankMinus" => intval(strip_tags($rankingMinus)),
        "id" => intval(strip_tags($_GET['id']))
    ]);
    header("Location: index.php");
    exit;
} else if (array_key_exists('rank', $_GET) && $_GET['prior'] == 'up') {
    $query3 = $dbCo->prepare("UPDATE task SET ranking = ranking + 1 WHERE ranking = :rank");
    $isOk3 = $query3->execute([
        "rank" => intval(strip_tags($ranking))
    ]);

    $query4 = $dbCo->prepare("UPDATE task SET ranking = ranking - 1 WHERE ranking = :rankPlus AND NOT Id_task = :id");
    $isOk4 = $query4->execute([
        "rankPlus" => intval(strip_tags($rankingPlus)),
        "id" => intval(strip_tags($_GET['id']))
    ]);
    header("Location: index.php");
    exit;
}