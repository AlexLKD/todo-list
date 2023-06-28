<?php
require 'includes/_database.php'
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
    <header>
        <h2 class="main-ttl">Todo-list</h2>
    </header>
    <section>
        <a href="index.php"><button type="button">Todo list</button></a>
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
</body>

</html>