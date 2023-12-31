<?php
require 'includes/_database.php';
require 'includes/_functions.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>tasks-done</title>
</head>

<body>
    <main class="container">
        <section>
            <a href="index.php"><button type="button">Todo list</button></a>
            <?php
            $query = $dbCo->prepare("SELECT ranking, Id_task, text FROM task WHERE status = '2' ORDER BY date_create ASC");
            $query->execute();
            $result = $query->fetchAll();
            echo '<h2>Tâches effectuées</h2><ul class="main-nav-list">';
            if (array_key_exists('msg', $_GET)) {
                echo '<p class="task-info">' . $_GET['msg'] . '</p>';
            }
            foreach ($result as $task) {
                echo '<li class="main-nav-item">' . $task['text'] . ' 
                <div>
                    <a href="actions.php?invalidate=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&token=' . $_SESSION['token'] . '" class="invalidate-link"><button type="submit" 
                    class="invalidate-button button" name="invalidate" value="' . $task['Id_task'] . '">❎</button></a>
                    <a href="actions.php?delete=' . $task['Id_task'] . '&token=' . $_SESSION['token'] . '" class="delete-link"><button type="submit" 
                    class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a></div> 
                    </li>';
            }
            echo '</ul>';
            ?>
        </section>
    </main>
</body>

</html>