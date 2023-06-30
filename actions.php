<?php

require 'includes/_database.php';


// submit task
if (isset($_POST['submit'])) {
    $queryPriority = $dbCo->prepare('SELECT MAX(priority_task)+1 AS newPriority FROM task');
    $isOk = $queryPriority->execute();
    $result = $queryPriority->fetch();
    // var_dump(intval($result['newPriority']));

    $task = $_POST['task'];
    $dateCreate = date('Y-m-d H:i:s');

    $query = $dbCo->prepare("INSERT INTO task (text, date_create, priority_task) VALUES (:text, :date_create, :priority_task)");

    $isOk = $query->execute([
        ':text' => strip_tags($task),
        ':date_create' => $dateCreate,
        ':priority_task' => (intval($result['newPriority']))
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

// Update task
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
    var_dump($isOk);
    header("Location: index.php?msg=" . ($isOk ? 'Tâche mise à jour' : 'Impossible de mettre à jour'));
    exit;
}

// ---------------------------------------
// lier au changement écrit des chiffres
// Update task
// if (isset($_POST['updateNumber'])) {
//     $taskId = $_POST['updateNumber'];
//     $newTask = $_POST['newNumber'];
//     $query = $dbCo->prepare("UPDATE task SET priority_task = :newNumber WHERE Id_task = :taskId");
//     $isOk = $query->execute([
//         ':newNumber' => strip_tags($newTask),
//         ':taskId' => strip_tags($taskId)
//     ]);
//     if ($query->rowCount()) {
//     }
//     var_dump($taskId);
//     exit;
//     header("Location: index.php?msg=" . ($isOk ? 'Tâche mise à jour' : 'Impossible de mettre à jour'));
//     exit;
// }


$rankingPlus = $_GET['rank'] +1;
$ranking = $_GET['rank'] ;
$rankingLess = $_GET['rank'] -1;
// ---------------------------------------
// lier au bouton up

if(array_key_exists('rank', $_GET) && $_GET['prior'] == 'down'){
    $query1 = $dbCo->prepare('UPDATE Id_task SET ranking = ranking - 1 WHERE ranking=:rank');
    $isOk1 = $query1 ->execute(["rank" => intval(strip_tags($ranking))]);

    $query2 = $dbCo->prepare('UPDATE Id_task SET ranking = ranking + 1 WHERE ranking=:rankingLess AND NOT Id_task = :id '  );
    $isOk2 = $query2 ->execute(["rankMinus" => intval(strip_tags($rankingLess)),
        "id" => intval(strip_tags($_GET['id']))
    
    
]);

}

else if (

    array_key_exists('rank', $_GET) && $_GET['prior'] == 'up'){
        $query3 = $dbCo->prepare('UPDATE Id_task SET ranking = ranking + 1 WHERE ranking=:rank');
        $isOk3 = $query3 ->execute(["rank" => intval(strip_tags($ranking))]);
    
        $query4 = $dbCo->prepare('UPDATE Id_task SET ranking = ranking - 1 WHERE ranking=:rankPlus AND NOT Id_task = :id');
        $isOk4 = $query4 ->execute(["rankPlus" => intval(strip_tags($rankingPlus)),
        "id" => intval(strip_tags($_GET['id']))
    
    ]);
    }

// if (isset($_POST['moveUpButton'])) {
//     $priorityTask = $_POST['moveUpButton'];
    
//     // Récupérer la tâche à déplacer
//     $queryTask = $dbCo->prepare('SELECT Id_task, priority_task FROM task WHERE priority_task = :priorityTask');
//     $queryTask->execute([':priorityTask' => strip_tags($priorityTask)]);
//     $task = $queryTask->fetch();
//    var_dump($priorityTask);
// exit;
   
//         $priorityTaskValue = intval($task['priority_task']);
//         $priorityTaskId = $task['Id_task'];
//         var_dump( $priorityTaskId);
//         exit;
//         $queryMoveUp = $dbCo->prepare("UPDATE task SET priority_task = priority_task +1 WHERE priority_task = :priorityTask");
//         $queryMoveUp->execute([':priorityTask' => $priorityTaskValue]);
        
//         // $priorityTaskValue = intval($task['priority_task']);
//         // $queryMoveUp = $dbCo->prepare("UPDATE task SET priority_task +1 = priority_task -1 WHERE priority_task = :priorityTask AND  Id_task <> :taskId ");
//         // $queryMoveUp->execute([':priorityTask' => $priorityTaskValue,
//         // ':taskId' =>$priorityTaskValue ]);
        
//         // Rediriger vers la page souhaitée
//         header('Location: index.php');
//         exit;
// }

    // if ($task) {
    //     $priorityTaskValue = $task['priority_task'];
    //     echo "Priority Task: " . $priorityTaskValue;
    // } else {
    //     echo "Tâche non trouvée";
    // }

    // exit;


    // UPDATE task SET priority_task = priority_task -1 WHERE priority_task = :taskIdq lkt

// // if ($task) {
// $currentPriority = $task['Id_task'];
// $newPriority = $currentPriority - 1;
// // var_dump($newPriority);
// //     exit;
// // Trouver la tâche "au-dessus" dans l'ordre
// $queryAbove = $dbCo->prepare("UPDATE task SET priority_task = priority_task -1 WHERE priority_task = :taskIdq ");
// $queryAbove->execute([':priorityTask' => $newPriority]);
// $taskAbove = $queryAbove->fetch();
// // var_dump($taskAbove);
// // exit;
// // }

// //         // Vérifier si la tâche "au-dessus" a une clé unique différente
// if ($taskAbove && $taskAbove['Id_task'] != $task['Id_task']) {
//     // Mettre à jour la tâche déplacée et la tâche "au-dessus"
//     $queryUpdateTask = $dbCo->prepare("UPDATE task SET priority_task = :newPriority WHERE Id_task = :taskId");
//     $queryUpdateTaskAbove = $dbCo->prepare("UPDATE task SET priority_task = :currentPriority WHERE Id_task = :taskIdAbove");

//     $isOk = $queryUpdateTask->execute([':newPriority' => $newPriority, ':taskId' => $taskId]);
//     $isOkAbove = $queryUpdateTaskAbove->execute([':currentPriority' => $currentPriority, ':taskIdAbove' => $taskAbove['Id_task']]);

//     if ($isOk && $isOkAbove) {
//         // Rediriger vers la page index.php avec un message
//         header('Location: index.php?msg=La tâche a été déplacée avec succès');
//         exit;
//     }}}

// } else {
//     // Trouver la priorité la plus basse disponible
//     $queryLowestPriority = $dbCo->query("SELECT MIN(priority_task) AS lowestPriority FROM task");
//     $lowestPriority = $queryLowestPriority->fetchColumn();

//     // Mettre à jour la tâche déplacée avec la priorité la plus basse disponible
//     $queryUpdateTask = $dbCo->prepare("UPDATE task SET priority_task = :newPriority WHERE Id_task = :taskId");
//     $isOk = $queryUpdateTask->execute([':newPriority' => $lowestPriority, ':taskId' => $taskId]);

//     if ($isOk) {
//         // Rediriger vers la page index.php avec un message

//         header('Location: index.php?msg=La tâche a été déplacée avec succès mais');
//         exit;
//     }
// }

//  else {
//   // La tâche n'existe pas
//   header('Location: index.php?msg=Tâche introuvable');
//   exit;
// }




// ---------------------------------------
//test up ne marche pas
// // Up task
// if (isset($_POST['up'])) {
//     $taskIndex = $_POST['up'];
//     $newIndex = $_POST[$index -1 ];
//     $query = $dbCo->prepare("UPDATE task SET $index = :newIndex WHERE Id_task = :taskId");
//     $isOk = $query->execute([
//         ':newTask' => strip_tags($newTask),
//         ':taskId' => strip_tags($taskId)
//     ]);
//     if ($query->rowCount()) {
//     }
//     header("Location: index.php?msg=" . ($isOk ? 'Tâche mise à jour' : 'Impossible de mettre à jour'));
//     exit;
// }


// global $dbCo;

// $requestBody = file_get_contents('php://input');
// $data = json_decode($requestBody, true);

// $action =( isset($_POST['action'])) ? $_POST['action'] : $data['action'];

// switch ($action) {
//     case 'add_task':
//         break;

//         default:
//         //code
//         break;
// }

// ---------------------------------------
// lier au JS

/* on vérifie que l'information "menu_destination" existe ET qu'elle n'est pas vide : */
if (isset($_POST['priority_task']) && !empty($_POST['priority_task']))

/* si c'est bien le cas (existe ET non-vide à la fois), on redirige le visiteur vers sa valeur choisie de l'information "menu_direction" : */ {
    header("Location: " . $_POST['priority_task'] . "");
}

/* sinon, on le redirige vers une autre page utile : */ else {
    header("Location: http://localhost/todo-list/index.php");
}





// function addTask(): void
// {
//     global $db;

//     if(!isset($POST['name'])) return;

//     $db ->addTask($_POST['name']);

//     echo json_encode([
//         'code' => 'ADD_TASK_OK',
//         'taskID' => $db->getDatabase()->lastInsertRowID(),
//         'taskName' => $_POST['taskName']
//     ]);
// }
// $data = json_decode(file_get_contents('php://input'), true); // Récupérer les données JSON envoyées

// // Traitez les données et effectuez les opérations nécessaires

// $response = array('success' => true, 'message' => 'Opération réussie');

// echo json_encode($response); // Renvoyez la réponse JSON

// $taskIds = isset($_POST['priority_task']) ? $_POST['priority_task'] : array();
 
// if (!empty($taskIds)) {
//     // Mettez à jour l'ordre des tâches dans votre base de données ou système de gestion des tâches
//     foreach ($data['taskIds'] as $index => $taskId) {
//             // Convertissez l'ID de la tâche en entier
//         $taskId = intval($taskId);
    
//         // Utilisez la valeur de $index pour déterminer la nouvelle position de la tâche
//         $order = $index + 1;
        
//         // Préparez la requête SQL pour mettre à jour l'ordre de la tâche
//         $sql = "UPDATE tasks SET priority_task = $order WHERE Id_task = :taskId";
    
//         // Exécutez la requête préparée en liant les valeurs des paramètres
//         $stmt = $pdo->prepare($sql);
//         // $stmt->bindParam(':order', $order, PDO::PARAM_INT);
//         $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
//         $stmt->execute();
//     }

//     $response = [
//         [
//             'success' => true,
//             'message' => 'Opération réussie'
//         ],
//         [
//             'success' => false,
//             'message' => 'Aucune tâche à mettre à jour.'
//         ]
//     ];
    
//     echo json_encode($response);}




// ---------------------------------------
// avec du jquery
//db details
// $db_host = 'localhost';
// $db_user = 'phplocal';
// $db_pass = 'phplocal';
// $db_name = 'li_php_demo';
 
// //connect and select db
// $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// $post_order_ids = isset($_POST["post_order_ids"]) ? $_POST["post_order_ids"] : [];

// if (count($post_order_ids) > 0) {
//     for ($order_no = 0; $order_no < count($post_order_ids); $order_no++) {
//         $taskId = strip_tags($post_order_ids[$order_no]);
//         $priority_task = $order_no + 1;

//         $query = "UPDATE task SET priority_task = ? WHERE Id_task = ?";
//         $stmt = $dbCo->prepare($query);
//         $stmt->execute([$priority_task, $taskId]);
//     }
    
//     echo json_encode(["success" => true]);
// } else {
//     echo json_encode(["success" => false]);
// }