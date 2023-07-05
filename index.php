<?php
require 'includes/_database.php';
require 'includes/_functions.php';

session_start();
$_SESSION['token'] = md5(uniqid(mt_rand(), true));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>todo-list</title>
</head>

<body>
    <header>
        <h1 class="main-ttl">Todo-list</h1>
    </header>
    <main class="container">
        <form action="actions.php" method="POST" class="form-submit">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>" id="token-csrf">
            <input type="text" name="task" placeholder="task" class="form-txt" required>
            <span class="required">*</span>
            <div class="form-date">
                <div>
                    <p>Rappel le :</p>
                    <input type="date" id="recall" name="new_date" value="">
                </div>
                <input type="submit" class="form-cta" name="submit" value="✔️">
            </div>
        </form>
        <?php

        $query = $dbCo->prepare("SELECT status ,theme ,recall, Id_task, text, ranking FROM task WHERE status = '1' ORDER BY ranking DESC");
        $query->execute();
        $result = $query->fetchAll();

        ?>
        <section>
            <a href="tasks-done.php"><button type="button">Tasks done</button></a>
            <?php

            echo '<h2>à faire</h2>';

            echo '<label for="pet-select">Choose theme:</label>
                    <select name="theme" id="theme-task"> 
                    <option value="">--Please choose an option--</option> 
                    ';

            echo implode("", selectTheme($result));
            // il faut que pour chaque valeur, option value doit ajouté
            echo '</select>';

            if (array_key_exists('msg', $_GET)) {
                echo '<p class="task-info">' . $_GET['msg'] . '</p>';
            }
            echo '<ul class="main-nav-list" id="list">';
            foreach ($result as $task) {
                echo '<li class="task-container" data-id="'  . $task['Id_task'].'" data-ranking="'. $task['ranking']. '">
                <div  class="main-nav-item">
                <div class="task-content">
                <p id="taskText_' . $task['Id_task'] . '">' . $task['text'] . '</p>
                <form action="actions.php" method="POST" class="update-form hidden">
                <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
                <input type="hidden" name="update" value="' . $task['Id_task'] . '">
                <input type="text" name="new_task" class="task-input" value="' . $task['text'] . '" required>
                <input type="date" id="recall_' . $task['Id_task'] . '" name="new_date" class="" value="' . $task['recall'] . '">
                <button type="submit" class="update-button button" value ="' . '">Save</button>
                </form>
                <button type="button" class="edit-button button" value="' . '"data-task-id="' . $task['Id_task'] . '">Edit</button>
                </div>
                <div>
                <p> ' . getDateText($task) . '</p>
                <button type="submit" class="validate-button button" name="validate" value="' . $task['Id_task'] .  '&token=' . $_SESSION['token'] .  '" >✔️</button></a>
                            <a href="actions.php?delete=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&token=' . $_SESSION['token'] . '" class="delete-link"><button type="submit" 
                                    class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a>
                            </div>
                        </div >
                        <div class="arrow-div">';
                if ($task['ranking'] == 1) {
                    echo '<a href="actions.php?id=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&token=' . $_SESSION['token'] . '&prior=up"><img class="arrow" src="img/up.png" alt="up"></a>';
                } elseif ($task['ranking'] == count($result)) {
                    echo '<a href="actions.php?id=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&token=' . $_SESSION['token'] . '&prior=down"><img class="arrow" src="img/down.png" alt="down"></a>';
                } else {
                    echo '<a href="actions.php?id=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&token=' . $_SESSION['token'] . '&prior=up"><img class="arrow" src="img/up.png" alt="up"></a>';
                    echo '<a href="actions.php?id=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&token=' . $_SESSION['token'] . '&prior=down"><img class="arrow" src="img/down.png" alt="down"></a>';
                }
                echo '</div>
                    </li>';
            }
            echo '</ul>';
            getRecallToday($result)
            ?>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>