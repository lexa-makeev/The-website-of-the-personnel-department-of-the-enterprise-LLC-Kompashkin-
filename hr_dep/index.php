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
        <title>Главная</title>
    </head>
    <body>
        <header>
            <div class="container">
                <p class="logo">Панель соискателя ООО "Компашкин"</p>
                <nav>
                    <ul>
                        <li>
                            <a class="main" href="#">Главная</a>
                        </li>
                        <li>
                            <a class="ankets" href="ankets.php">Анкеты</a>
                        </li>
                        <li>
                            <a class="send_anket" href="podacha.php">Подать анкету</a>
                        </li>
                    </ul>
                </nav>
                <p class="name"><?php echo $db->get_name($id); ?></p>
            </div>
        </header>
        <section>
            <div class="container">
                <h1>Статус анкеты</h1>
            </div>
            <div class="block_status">
                 <div class="container"> 
                    <?php
                        $data = $db->get_anketa($id);
                        if ($data != null) {
                            echo '<p class="id">Анкета <span>#'.$data["id_anketa"].'</span></p>
                            <p class="status">'.$data["status"].'</p>
                            <a href="ankets.php">Посмотреть</a>';
                        }
                        else {
                            echo '<p class="not_anket">На текущий момент анкет нет</p>';
                        }
                    ?>
                    <!-- <p class="id">Анкета <span>#23123</span></p>
                    <p class="status">На рассмотрении</p>
                    <a href="#">Посмотреть</a> -->
                </div>
            </div>
        </section>
    </body>
</html>