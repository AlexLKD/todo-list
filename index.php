<?php
require 'includes/_database.php';
require 'includes/_functions.php';

// session_start();
// $_SESSION['token'] = md5(uniqid(mt_rand(), true))
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
                    <!-- ici -->
                    <p>Rappel le :</p>
                    <!-- <input type="date" name="due_date"> -->
                    <input type="date" id="recall" name="new_date" >
                </div>
                <input type="submit" class="form-cta" name="submit" value="✔️">
                <input type="hidden" name="token" value="">

            </div>
        </form>

        <section>
            <a href="tasks-done.php"><button type="button">Tasks done</button></a>
            <?php

                    $query = $dbCo->prepare("SELECT theme ,recall, Id_task, text, ranking FROM task WHERE status = '1' ORDER BY ranking DESC");
                    $query->execute();
                    $result = $query->fetchAll();             
                   
                    
                    
                    echo '<h2>à faire</h2><ul class="main-nav-list"> ';
                    
                    echo '<label for="pet-select">Choose theme:</label>
                    <select name="theme" id="theme-task"> 
                    <option value="">--Please choose an option--</option> 
                    ';
                    
                    echo implode("" ,selectTheme($result));
                    echo '</select>';
                    
                     
                    if (array_key_exists('msg', $_GET)) {
                        echo '<p class="task-info">' . $_GET['msg'] . '</p>';
                    }
                    foreach ($result as $task) {

                echo '<li class="main-nav-item">
                        <div class="task-content">
                            <p id="taskText_' . $task['Id_task'] . '">' . $task['text'] . '</p>
                            <form action="actions.php" method="POST" class="update-form">
                                <input type="hidden" name="update" value="' . $task['Id_task'] . '">
                                <input type="text" name="new_task" class="task-input hidden" value="' . $task['text'] . '" required>
                                <button type="button" class="edit-button button" data-task-id="' . $task['Id_task'] . '">Edit</button>
                                <button type="submit" class="update-button button hidden">Save</button>
                            </form>
                        </div>
                        <div>
                        
                        <form action="actions.php" method="POST" class="update-form">
                        <input type="hidden" name="call" value="' . $task['Id_task'] . '">
                        <input type="date" id="recall" name="new_date" required="" value= "'. $task['recall'] .'" >  
                        <button type="submit" class="update-button button">Call</button>
                        
                        </form>


                        </div>
                        <div>
                            <a href="actions.php?validate=' . $task['Id_task'] . '" class="validate-link"><button type="submit" 
                            class="validate-button button" name="validate" value="' . $task['Id_task'] . '">✔️</button></a>
                            <a href="actions.php?delete=' . $task['Id_task'] . '" class="delete-link"><button type="submit" 
                            class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a>
                        </div>
                        <div><a href="actions.php?id=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&prior=down"><img class="arrow" src="img/down.png" alt="down"></a>
                        <a href="actions.php?id=' . $task['Id_task'] . '&rank=' . $task['ranking'] . '&prior=up"><img class="arrow" src="img/up.png" alt="up"></a></div>
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