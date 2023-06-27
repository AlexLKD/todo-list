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
            <input type="text" placeholder="task" class="form-txt">
            <input type="submit" class="form-cta" name="image" value="✔️">
            <div>
                <p>à faire avant le :</p>
                <input type="date">
            </div>
        </form>

        <section>
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
            $query = $dbCo->prepare("SELECT text FROM task;");
            $query->execute();
            $result = $query->fetchAll();
            echo '<ul class"main-nav-list">';
            foreach ($result as $task) {
                echo '<li class="main-nav-item"> ' . $task['text'] . '</li>';
            }
            echo '</ul>';
            ?>

        </section>
    </main>
</body>

</html>