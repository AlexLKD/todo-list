<?php

require 'includes/_database.php';

// SUBMIT TASK
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

//-----------------------------------------------------------

// DELETE TASK
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

//-----------------------------------------------------------

// VALIDATE TASK
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

//-----------------------------------------------------------

// INVALIDATE TASK
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

//-----------------------------------------------------------

// UPDATE TASK
if (isset($_POST['update'])) {
    $taskId = $_POST['update'];
    $newTask = $_POST['new_task'];
    $query = $dbCo->prepare("UPDATE task SET text = :newTask WHERE Id_task = :taskId");
    $isOk = $query->execute([
        ':newTask' => strip_tags($newTask),
        ':taskId' => strip_tags($taskId)
    ]);
    if ($query->rowCount()) {
    }
    header("Location: index.php?msg=" . ($isOk ? 'Tâche mise à jour' : 'Impossible de mettre à jour'));
    exit;
}
// if (isset($_POST['update'])) {
//     $taskId = $_POST['update'];
//     $newTask = $_POST['new_task'];
//     $dateReminder = isset($_POST['date_reminder']);


//     $query = $dbCo->prepare("UPDATE task SET text = :newTask, date_reminder = :dateReminder WHERE Id_task = :taskId");

//     // Check if there's a reminder date already
//     if ($dateReminder !== null) {
//         $query->bindValue(':dateReminder', $dateReminder);
//     } else {
//         // If there's no reminder set then ignore 
//         $query->bindValue(':dateReminder', null, PDO::PARAM_NULL);
//     }

//     $isOk = $query->execute([
//         ':newTask' => strip_tags($newTask),
//         ':taskId' => strip_tags($taskId)
//     ]);

//     if ($query->rowCount()) {
//         // La tâche a été mise à jour avec succès
//     }

//     header("Location: index.php?msg=" . ($isOk ? 'Tâche mise à jour' : 'Impossible de mettre à jour'));
//     exit;
// }
