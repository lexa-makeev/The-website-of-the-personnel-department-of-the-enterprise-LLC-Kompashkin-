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
        <title>Анкеты</title>
    </head>
    <body>
        <header>
            <div class="container">
                <p class="logo">Панель соискателя ООО "Компашкин"</p>
                <nav>
                    <ul>
                        <li>
                            <a class="main" href="index.php">Главная</a>
                        </li>
                        <li>
                            <a class="ankets" href="#">Анкеты</a>
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
                <h1>Анкеты</h1>
                <div class="block_info">
                        <?php
                            $data = $db->get_anketa_info($id);
                            if ($data != null) {
                                echo "
                                <div class='left_info'>
                                    <p class='number'>
                                        Личный номер: <span>".$data["id_anketa"]."</span>
                                    </p>
                                    <p class='fam'>
                                        Фамилия: <span>".$data["fam"]."</span>
                                    </p>
                                    <p class='name'>
                                        Имя: <span>".$data["name"]."</span>
                                    </p>
                                    <p class='otch'>
                                        Отчество: <span>".$data["otch"]."</span>
                                    </p>
                                    <p class='birthday'>
                                        Дата рождения: <span>".$data["date_birthday"]."</span>
                                    </p>
                                    <p class='pol'>
                                        Пол: <span>".$data["pol"]."</span>
                                    </p>
                                    <p class='mesto_rojdenia'>
                                        Место рождения: <span>".$data["mesto_rojdenia"]."</span>
                                    </p>
                                    <p class='grajdanstvo'>
                                        Гражданство: <span>".$data["grajdanstvo"]."</span>
                                    </p>
                                    <p class='obrazovanie'>
                                        Образование: <span>".$data["obrazovanie"]."</span>
                                    </p>
                                    <p class='telephone'>
                                        Телефон: <span>".$data["telephone"]."</span>
                                    </p>
                                    <p class='vacans'>
                                        Желаемая вакансия: <span>".$db->get_name_post($data["id_post"])."</span>
                                    </p>
                                </div>
                                <div class='right_info'>
                                    <p class='resume'>
                                        Резюме: <span>".$data["resume"]."</span>
                                    </p>
                                </div>
                                <p class='stat'>
                                    Статус заявки: <span>".$data["status"]."</span>
                                </p>
                                ";
                            }
                            else {
                                echo "<p class='not_anket'>Ошибочка, анкеты у Вас нет</p>";
                            }
                        ?>
                    <!-- <div class="left_info">
                        <p class="number">
                            Личный номер: <span>931</span>
                        </p>
                        <p class="fam">
                            Фамилия: <span>Пулькин</span>
                        </p>
                        <p class="name">
                            Имя: <span>Будько</span>
                        </p>
                        <p class="otch">
                            Отчество: <span>Отец</span>
                        </p>
                        <p class="snils">
                            СНИЛС: <span>176-231-323 92</span>
                        </p>
                        <p class="passport">
                            Паспортные данные: <span>2132 123211</span>
                        </p>
                        <p class="birthday">
                            Дата рождения: <span>42.14.2012</span>
                        </p>
                        <p class="job_last">
                            Предыдущее место работы: <span>предыдун</span>
                        </p>
                        <p class="obraz">
                            Образование: <span>Умное</span>
                        </p>
                    </div>
                    <div class="right_info">
                        <p class="stas">
                            Стаж: <span>90</span>
                        </p>
                        <p class="tel">
                            Телефон: <span>88888888888</span>
                        </p>
                        <p class="proj">
                            Адрес проживания: <span>Дома</span>
                        </p>
                        <p class="reg">
                            Адрес регистрации: <span>Дома</span>
                        </p>
                    </div>
                    <p class="stat">
                        Статус заявки: <span>Одобрено</span>
                    </p> -->
                </div>
            </div>
        </section>
    </body>
</html>