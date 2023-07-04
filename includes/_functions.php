<?php
function selectTheme($result)
{
    $arrayTheme = array_map(fn ($task) => $task['theme'], $result);
    $uniqueTheme = array_unique($arrayTheme);
    return  $allTheme = array_map(fn ($v) => '<option value=' . $v . '>' . $v . '</option> ', $uniqueTheme);
};

function getRecallFromToday($task)
{
    $dt = date('Y-m-d');
    if ($task['recall'] === $dt) {
        echo '<a href = #taskText_' . $task['Id_task'] .  '><p>' . $task['text'] . ' </p> </a>';
    }
};
function getRecallToday($array)
{ { {
            echo '<aside class="aside"><h2>Tâches urgentes</h2>';
            foreach ($array as $task) {
                echo  getRecallFromToday($task);
            };
            echo '</aside>';
        }
    }
}
