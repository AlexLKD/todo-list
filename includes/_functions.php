<?php
function getList(array $array): string
{
    $html = '<h2>à faire</h2><ul class="main-nav-list">';
    if (array_key_exists('msg', $_GET)) {
        $html .= '<p class="task-info">' . $_GET['msg'] . '</p>';
    }
    foreach ($array as $task) {
        $html .= '<li class="main-nav-item">';
        $html .= '<div class="task-content">';
        $html .=         '<p id="taskText_' . $task['Id_task'] . '">' . $task['text'] . '</p>';
        $html .=   '<form action="actions.php" method="POST" class="update-form">';
        $html .=          '<input type="hidden" name="update" value="' . $task['Id_task'] . '">';
        $html .=        '<input type="text" name="new_task" class="task-input hidden" value="' . $task['text'] . '" required>';
        $html .=        '<button type="button" class="edit-button button" data-task-id="' . $task['Id_task'] . '">Edit</button>';
        $html .=        '<button type="submit" class="update-button button hidden">Save</button>';
        $html .=    '</form>';
        $html .= '</div>';
        $html .= '<div>';
        $html .=     '<a href="actions.php?validate=' . $task['Id_task'] . '" class="validate-link"><button type="submit"';
        $html .=     'class="validate-button button" name="validate" value="' . $task['Id_task'] . '">✔️</button></a>';
        $html .=     '<a href="actions.php?delete=' . $task['Id_task'] . '" class="delete-link"><button type="submit"';
        $html .=     'class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a>';
        $html .= '</div>';
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

// function getList(array $array): string
// {
//     $html = '<ul class="list">';
//     foreach ($array as $task) {
//         if ($task['is_completed'] == 0) {
//             $img = 'img/checkbox.png" alt="checkbox"';
//         } else {
//             $img = 'img/checkbox_completed.png"';
//         }
//         $html .= '<li class="task"><a href="updatestatus.php?is_completed=' . $task['is_completed'] . '&id=' . $task['id_task'] . '" class="list-item"><img src="' . $img . '" id="checkboxChecked">';
//         $html .= $task['title'] . '</a>';
//         $html .= '<div><a href="updateranking.php?id=' . $task['id_task'] . '&rank='.$task['ranking'].'&prior=down"><img src="img/down.svg" alt="down"></a>';
//         $html .= '<a href="updateranking.php?id=' . $task['id_task'] . '&rank='.$task['ranking'].'&prior=up"><img src="img/up.svg" alt="up"></a></div>';
//         $html .= "</li>";
//     }
//     $html .= '</ul>';
//     return $html;
// }