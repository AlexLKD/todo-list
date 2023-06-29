<?php
require 'includes/_database.php'
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
        <form action="actions.php" method="POST">
            <input type="text" name="task" placeholder="task" class="form-txt" required>
            <span class="required">*</span>
            <div class="form-date">
                <div>
                    <p>Rappel le :</p>
                    <input type="date" name="due_date">
                </div>
                <input type="submit" class="form-cta" name="submit" value="✔️">
            </div>
        </form>

        <section>
            <?php

            $query = $dbCo->prepare("SELECT Id_task, text FROM task WHERE status = '1' ORDER BY date_create ASC");
            $query->execute();
            $result = $query->fetchAll();
            echo '<h2>à faire</h2><ul class="main-nav-list">';
            if (array_key_exists('msg', $_GET)) {
                echo '<p class="task-info">' . $_GET['msg'] . '</p>';
            }
            foreach ($result as $task) {
                // echo '<li class="main-nav-item">' . '<p>' . $task['text'] . '</p>' . ' 
                echo '<li class="main-nav-item">' . '<p>' . '<input type="text" class="task-input" id="taskInput_' . $task['Id_task'] . '" value="' . $task['text'] . '" disabled>' . '</p>' . '
                    <div draggable="true">
                        <a href="actions.php?validate=' . $task['Id_task'] . '" class="validate-link"><button type="submit" 
                        class="validate-button button" name="validate" value="' . $task['Id_task'] . '">✔️</button></a>
                        <a href="actions.php?delete=' . $task['Id_task'] . '" class="delete-link"><button type="submit" 
                        class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a>
                        <form action="actions.php" method="POST" class="update-form">
                        <input type="hidden" name="update" value="' . $task['Id_task'] . '">
                        <input type="text" name="new_task" class="task-input" value="' . $task['text'] . '" required>
                        <button type="submit" class="update-button button">Edit</button>
</form>

                    </div>
                </li>';
            }
            echo '</ul>';
            echo '<h2>à faire</h2><ul class="main-nav-list">';
            ?>
            <a href="tasks-done.php"><button type="button">Tasks done</button></a>
        </section>
        <section>
            <?php
            // $query = $dbCo->prepare("SELECT Id_task, text FROM task WHERE status = '2' ORDER BY date_create ASC");
            // $query->execute();
            // $result = $query->fetchAll();
            // echo '<h2>fait</h2><ul class="main-nav-list">';
            // foreach ($result as $task) {
            //     echo '<li class="main-nav-item">' . $task['text'] . ' 
            //     <div>
            //         <a href="actions.php?invalidate=' . $task['Id_task'] . '" class="invalidate-link"><button type="submit" 
            //         class="invalidate-button button" name="invalidate" value="' . $task['Id_task'] . '">❎</button></a>
            //         <a href="actions.php?delete=' . $task['Id_task'] . '" class="delete-link"><button type="submit" 
            //         class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a></div> 
            //         </li>';
            // }
            // echo '</ul>';
            ?>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>