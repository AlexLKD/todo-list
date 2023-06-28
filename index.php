<?php
try {
    $dbCo = new PDO(
        'mysql:host=localhost;dbname=todo-list;charset=utf8',
        'phplocal',
        'phplocal'
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (Exception $e) {
    die('Unable to connect to the database.
        ' . $e->getMessage());
}

if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    $dateCreate = date('Y-m-d H:i:s');
    $query = $dbCo->prepare("INSERT INTO task (text, date_create) VALUES (:text, :date_create)");
    $query->execute([
        ':text' => strip_tags($task),
        ':date_create' => $dateCreate
    ]);
}

if (isset($_GET['delete'])) {
    $taskId = $_GET['delete'];
    $query = $dbCo->prepare("DELETE FROM task WHERE Id_task = :taskId");
    $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    if ($query->rowCount()) {
        echo '<p class="transition" id="message"> La tâche a été supprimée.</p>';
    };
}

if (isset($_GET['validate'])) {
    $taskId = $_GET['validate'];
    $query = $dbCo->prepare("UPDATE task SET status = '2' WHERE Id_task = :taskId");
    $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
    if ($query->rowCount()) {
        echo '<p class="transition" id="message">La tâche a été effectuée.</p>';
    };
}
if (isset($_GET['invalidate'])) {
    $taskId = $_GET['invalidate'];
    $query = $dbCo->prepare("UPDATE task SET status = '1' WHERE Id_task = :taskId");
    $query->execute([
        ':taskId' => strip_tags($taskId)
    ]);
}
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
        <form action="" method="POST">
            <input type="text" name="task" placeholder="task" class="form-txt" required>
            <span class="required">*</span>
            <div class="form-date">
                <div>
                    <p>à faire avant le :</p>
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
            foreach ($result as $task) {
                // '<input type="text" class="task-input" id="taskInput_' . $task['Id_task'] . '" value="' . $task['text'] . '" disabled>'
                // echo '<li class="main-nav-item">' . '<p>' . '<input type="text" class="task-input" id="taskInput_' . $task['Id_task'] . '" value="' . $task['text'] . '" disabled>' . '</p>' . ' 
                echo '<li class="main-nav-item">' . '<p>' . $task['text'] . '</p>' . ' 
                    <div draggable="true">
                        <a href="index.php?validate=' . $task['Id_task'] . '" class="validate-link"><button type="submit" 
                        class="validate-button button" name="validate" value="' . $task['Id_task'] . '">✔️</button></a>
                        <a href="index.php?delete=' . $task['Id_task'] . '" class="delete-link"><button type="submit" 
                        class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a>
                        <button type="button" class="edit-button button" onclick="enableEdit(\'' . $task['Id_task'] . '\')">Edit</button>
                        
                    </div>
                </li>';
            }
            echo '</ul>';

            ?>

        </section>
        <section>
            <?php
            $query = $dbCo->prepare("SELECT Id_task, text FROM task WHERE status = '2' ORDER BY date_create ASC");
            $query->execute();
            $result = $query->fetchAll();
            echo '<h2>fait</h2><ul class="main-nav-list">';
            foreach ($result as $task) {
                echo '<li class="main-nav-item">' . $task['text'] . ' 
                <div>
                    <a href="index.php?invalidate=' . $task['Id_task'] . '" class="invalidate-link"><button type="submit" 
                    class="invalidate-button button" name="invalidate" value="' . $task['Id_task'] . '">❎</button></a>
                    <a href="index.php?delete=' . $task['Id_task'] . '" class="delete-link"><button type="submit" 
                    class="delete-button button" name="delete" value="' . $task['Id_task'] . '">❌</button></a></div> 
                    </li>';
            }
            echo '</ul>';
            ?>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>