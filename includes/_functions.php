<?php

$dt = date('Y-m-d');
function getRecallToday($array) {{

    { echo '<aside class="aside"><h2>Tâches urgentes</h2>';
        foreach ($array as $task) {
        echo  getRecallFromToday($task);};
       echo '</aside>';
        // return $html;
    }
}}
function getRecallFromToday($task ){
    global $dt;
    if($task['recall'] === $dt){
        echo '<a href = #taskText_' . $task['Id_task'] .  '><p>' .$task['text'].' </p> </a>' ; }};

        
function getDateText($task){
            global$dt;
if($task['recall'] === $dt){
  return  "aujourd'hui";
}
elseif ($task['recall'] === date('Y-m-d', strtotime('+1 day'))){
    return "demain";
}
elseif ($task['recall'] == '0000-00-00'){
    return " ";
}
else{
    return $task['recall'];
}
}


function selectTheme($result)
        {    $arrayTheme = array_map(fn ($task) => $task['theme'], $result);
            $uniqueTheme = array_unique($arrayTheme);
            
         return  $allTheme= array_map(fn($v) => '<option value='.$v.'>'.$v.'</option> '  ,$uniqueTheme);
        };

// function sortRanking($result){
//     $arrayTheme = array_map(fn ($task) => $task['ranking'], $result);
//     var_dump($arrayTheme);

// }