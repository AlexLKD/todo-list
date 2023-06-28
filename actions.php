<?php

require 'includes/_database.php';

// submit task
if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    $dateCreate = date('Y-m-d H:i:s');
    $query = $dbCo->prepare("INSERT INTO task (text, date_create) VALUES (:text, :date_create)");
    $isOk = $query->execute([
        ':text' => strip_tags($task),
        ':date_create' => $dateCreate
    ]);
    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été ajoutée' : 'Un problème a été rencontré lors de l\'ajout de la tâche'));
    exit;
}
// message if task is submit
if (array_key_exists('task', $_POST)) {
    // echo '<p class="transition" id="message"> La tâche a été ajoutée. </p>';
};


// delete task
if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    $query = $dbCo->prepare("DELETE FROM task WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    // message if task is deleted
    if ($query->rowCount()) {
        // echo '<p class="transition" id="message"> La tâche a été supprimée.</p>';
    };
    header('Location: tasks-done.php?msg=' . ($isOk ? 'La tâche a été supprimée' : 'La tâche n\'a pas pu être supprimée'));
    exit;
}


// validate task
if (isset($_GET['validate'])) {
    $taskId = $_GET['validate'];
    $query = $dbCo->prepare("UPDATE task SET status = '2' WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    // message if task is validated
    if ($query->rowCount()) {
        // echo '<p class="transition" id="message"> La tâche a été validée. </p>';
    };
    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été validée' : 'Un problème est survenu lors de la validation'));
    exit;
}


// invalidate task
if (isset($_GET['invalidate'])) {
    $taskId = $_GET['invalidate'];
    $query = $dbCo->prepare("UPDATE task SET status = '1' WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    // message if task is invalidated
    if ($query->rowCount()) {
        // echo '<p class="transition" id="message"> La tâche a été invalidée. </p>';
    };
    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été invalidée' : 'La tâche est toujours validée'));
    exit;
}
