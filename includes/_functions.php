<?php
function selectTheme($result)
{
    $arrayTheme = array_map(fn ($task) => $task['theme'], $result);
    $uniqueTheme = array_unique($arrayTheme);
    // var_dump($uniqueStyles);
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
            // return $html;
        }
    }
}


function displayArrows($taskId, $ranking, $taskCount)
{
    if ($ranking == 1) {
        return '<div><img class="arrow" src="img/up.png" alt="up"></div>';
    } elseif ($ranking == $taskCount) {
        return '<div><img class="arrow" src="img/down.png" alt="down"></div>';
    } else {
        return '<div>
                    <a href="actions.php?id=' . $taskId . '&rank=' . $ranking . '&prior=down"><img class="arrow" src="img/down.png" alt="down"></a>
                    <a href="actions.php?id=' . $taskId . '&rank=' . $ranking . '&prior=up"><img class="arrow" src="img/up.png" alt="up"></a>
                </div>';
    }
}
