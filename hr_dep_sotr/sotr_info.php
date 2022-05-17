<?php
    include "hrlib.php";
    $db = new DB;

    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
        header('Location: login.html');
    }

    $id_worker = $_GET["id"];
    if (empty($id_worker)) {
        header('Location: index.php');
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
        <link rel="stylesheet" href="css/anketa.css">
        <title>Анкеты</title>
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
                <h1>Личное дело сотрудника</h1>
                <div class="block_info">
                        <?php
                            $data = $db->get_info_sotr($id_worker);
                            if ($data != null) {
                                $date_birthday = new DateTime($data["date_birthday"]);
                                echo "
                                <div class='left_info'>
                                    <p class='number'>
                                        Номер личного дела: ".$data["id_lichdelo"]."
                                    </p>
                                    <p class='fam'>
                                        Фамилия: ".$data["fam"]."
                                    </p>
                                    <p class='name'>
                                        Имя: ".$data["name"]."
                                    </p>
                                    <p class='otch'>
                                        Отчество: ".$data["otch"]."
                                    </p>
                                    <p class='birthday'>
                                        Дата рождения: ".$date_birthday->format('d.m.Y')."
                                    </p>
                                    <p class='pol'>
                                        Пол: ".$data["pol"]."
                                    </p>
                                    <p class='mesto_rojdenia'>
                                        Место рождения: ".$data["mesto_rojdenia"]."
                                    </p>
                                    <p class='grajdanstvo'>
                                        Гражданство: ".$data["grajdanstvo"]."
                                    </p>
                                </div>
                                <div class='right_info'>
                                    <p class='obrazovanie'>
                                        Образование: ".$data["obrazovanie"]."
                                    </p>
                                    <p class='telephone'>
                                        Телефон: ".$data["telephone"]."
                                    </p>
                                    <p class='name_post'>
                                        Должность: ".$data["name_post"]."
                                    </p>
                                    <p class='cash'>
                                        Заработная плата: ".$data["cash"]."руб
                                    </p>
                                    <p class='resume'>
                                        Резюме из анкеты: ".$data["resume"]."
                                    </p>
                                </div>
                                ";
                            }
                            else {
                                echo "<p class='not_anket'>Ошибочка, личного дела сотрудника нет</p>";
                            }
                        ?>
                    
                </div>
                <!-- <div class='btns'>
                    <a class='odobr'>Одобрить</a>
                    <a href="change_anketa.php?id=<?php echo $id_anketa; ?>" class='change'>Изменить</a>
                    <a class='otmena'>Отклонить</a>
                </div> -->
            </div>
        </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function(){
            $("a.odobr").click(function(event){
                event.preventDefault();
                var result = confirm("Вы уверены, что хотите одобрить анкету?");
                if (result) {
                    $.ajax({
                    type: "POST",
                    url: "odobr_anketa.php",
                    data: "id=<?php echo $id_anketa; ?>",
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Кто наделал?");
                                break;
                            case "2":
                                alert("Произошла ошибка, попробуйте позже.");
                                break;
                            case "3":
                                alert("Анкета успешно одобрена.");
                                window.location.href = "index.php";
                                break;
                            default:
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
                }
            });
            $("a.otmena").click(function(event){
                event.preventDefault();
                var result = confirm("Вы уверены, что хотите отклонить анкету?");
                if (result) {
                    $.ajax({
                    type: "POST",
                    url: "delete_anketa.php",
                    data: "id=<?php echo $id_anketa; ?>",
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Кто наделал?");
                                break;
                            case "2":
                                alert("Произошла ошибка, попробуйте позже.");
                                break;
                            case "3":
                                alert("Анкета успешно отклонена.");
                                window.location.href = "index.php";
                                break;
                            default:
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
                }
            });
        });
    </script>
</html>