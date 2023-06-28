<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="style.css">
    <title>todo-list</title>
</head>

<body>
    <header>
        <h1 class="main-ttl">Todo-list</h1>
    </header>
    <main class="container">
        <form action="" method="POST">
            <input type="text" name="task" placeholder="task" class="form-txt">
            <input type="submit" class="form-cta" name="submit" value="✔️">
            <div>
                <p>à faire avant le :</p>
                <input type="date" name="due_date">
            </div>
        </form>

        <section>
            <?php
         try {
            $dbCo = new PDO(
            'mysql:host=localhost;dbname=todo_list;charset=utf8',
        'phplocal',
        'phplocal'
        );
        $dbCo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
        die('Unable to connect to the database.
        '.$e->getMessage());
        }
        

            if (isset($_POST['submit'])) {
                $task = $_POST['task'];
                $dateCreate = date('Y-m-d H:i:s');
                $query = $dbCo->prepare("INSERT INTO task (text, date_create) VALUES (:text, :date_create)");
                $query->execute([
                    ':text' => $task,
                    ':date_create' => $dateCreate
                ]);
            }

            if (isset($_POST['delete'])) {
                $taskId = $_POST['delete'];
                $query = $dbCo->prepare("DELETE FROM task WHERE Id_task = :taskId");
                $query->execute([
                    ':taskId' => $taskId
                ]);
            }

            if (isset($_POST['validate'])) {
                $taskId = $_POST['validate'];
                $query = $dbCo->prepare("UPDATE task SET status = '2' WHERE Id_task = :taskId");
                $query->execute([
                    ':taskId' => $taskId
                ]);
            }

            $query = $dbCo->prepare("SELECT Id_task, text FROM task WHERE status = '1' ORDER BY date_create ASC");
            $query->execute();
            $result = $query->fetchAll();
            echo '<ul class="main-nav-list">';
            foreach ($result as $task) {
                echo '<li class="main-nav-item">' . $task['text'] . '
                <div class="main-nav-form" action="" method="POST" class="delete-form">                
                <button type="submit" class="button" name="delete" value="' . $task['Id_task'] . '">✔️</button>                
                <button type="submit" class="button" name="delete" value="' . $task['Id_task'] . '">❌</button> </div> </li>';
            }
            echo '</ul>';
            ?>

        </section>
    </main>
</body>

</html>