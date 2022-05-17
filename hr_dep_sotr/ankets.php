<?php
    include "hrlib.php";
    $db = new DB;

    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
        header('Location: login.html');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/ankets.css">
        <title>Главная</title>
    </head>
    <body>
        <header>
            <div class="container">
                <p class="logo">Панель сотрудника ООО "Компашкин"</p>
                <nav>
                    <ul>
                        <li>
                            <a class="main" href="index.php">Главная</a>
                        </li>
                        <li>
                            <a class="ankets" href="ankets.php">Анкеты</a>
                        </li>
                        <li>
                            <a class="send_anket" href="sotr.php">Сотрудники</a>
                        </li>
                        <li>
                            <a class="analyse" href="analyse.php">Анализ</a>
                        </li>
                        <li>
                            <a class="vacans" href="vacans.php">Вакансии</a>
                        </li>
                    </ul>
                </nav>
                <p class="name"><?php echo $db->get_name($id); ?></p>
            </div>
        </header>
        <section>
            <div class="container">
                <h1>Анкеты</h1>
            </div>
            <?php
                $data = $db->get_all_ankets();
                if ($data != null) {
                    foreach ($data as $key => $value) {
                        echo '<div class="block_status">
                                <div class="container">
                                    <p class="id">Анкета <span>#'.$value["id_anketa"].'</span></p>
                                    <p class="status">'.$value["status"].'</p>
                                    <a href="anketa.php?id='.$value["id_anketa"].'">Посмотреть</a>
                                </div>
                            </div>';
                    }
                }
                else {
                    echo '<div class="block_status">
                            <div class="container">
                                <p class="not_anket">На текущий момент новых анкет нет</p>
                            </div>
                        </div>';
                }
            ?>
        </section>
    </body>
</html>