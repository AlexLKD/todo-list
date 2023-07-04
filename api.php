<?php

// if($_REQUEST['action'] === 'submit'){
//     $queryPriority = $dbCo->prepare('SELECT MAX(ranking) + 1 AS newPriority FROM task');
//     $isOk = $queryPriority->execute();
//     $result = $queryPriority->fetch();
// }

header('content-type:application/json');
$datas = [
    'result' => true,
    'message' => 'Everything is okay',
    'newId' => 52
];
echo json_encode($datas);
