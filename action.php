<?php



if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    $dateCreate = date('Y-m-d H:i:s');
    $query = $dbCo->prepare("INSERT INTO task (text, date_create) VALUES (:text, :date_create)");
    $query->execute([
        ':text' => strip_tags($task),
        ':date_create' => $dateCreate
    ]);
}

if(array_key_exists('task', $_POST )){
    echo '<p class="transition" id="message"> message validé </p>';
}; 


if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    $query = $dbCo->prepare("DELETE FROM task WHERE Id_task = :taskId");
   $isOk = $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    if($query -> rowCount()){
        echo '<p class="transition" id="message"> tache supprimé</p>';
     } ;
    // echo '<p class="transition" id="message">' .($isOk ?  'tache ajoutée' : 'problème lors de lajout')
    header('localisation: index.php?msg='.($isOk ?'add_ok' :'pas_ok'));
exit;
} 




if (isset($_GET['validate'])) {
    $taskId = $_GET['validate'];
    $query = $dbCo->prepare("UPDATE task SET status = '2' WHERE Id_task = :taskId");
    $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    if($query -> rowCount()){
        echo '<p class="transition" id="message"> tache effectué</p>';
     } ;
}
if (isset($_GET['invalidate'])) {
    $taskId = $_GET['invalidate'];
    $query = $dbCo->prepare("UPDATE task SET status = '1' WHERE Id_task = :taskId");
    $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    if($query -> rowCount()){
        echo '<p class="transition" id="message"> tache invalide</p>';
     } ;
}

?>