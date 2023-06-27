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
            <input type="text" placeholder="task" class="form-txt">
            <input type="submit" class="form-cta" name="image" value="✔️">
            <div>
                <p>à faire avant le :</p>
                <input type="date">
            </div>
        </form>

        <section>
            <?php
                
            $query = $dbCo->prepare("SELECT text FROM task;");
            $query->execute();
            $result = $query->fetchAll();


            // foreach($result as $product) {
            //     echo '<li>'.$product['text'].'</li>';
            //     }
     
                
            $tasks = [
                ['id' => '1', 'text' => 'task 1', 'date' => '2022-10', 'status' => 1],
                ['id' => '2', 'text' => 'task 2', 'date' => '2022-15', 'status' => 1],
                ['id' => '3', 'text' => 'task 3', 'date' => '2022-22', 'status' => 1],
                ['id' => '4', 'text' => 'task 4', 'date' => '2022-04', 'status' => 1],
                ['id' => '5', 'text' => 'task 5', 'date' => '2022-11', 'status' => 1],
                ['id' => '6', 'text' => 'task 6', 'date' => '2022-09', 'status' => 1]
            ];


            function createMenu(array $tasks): string
            {
                $menu = '<ul class="main-nav-list">';
                foreach ($tasks as $task) {
                    $menu .= '<li class="main-nav-item"> ' . $task['text'] . '</li>' ;
                }
                $menu .= '</ul>';
                return $menu;
            }

            ?>
            <?= createMenu($result) ?>
        </section>
    </main>
</body>

</html>