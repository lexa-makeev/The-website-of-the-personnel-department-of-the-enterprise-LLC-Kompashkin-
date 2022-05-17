<?php
    include "hrlib.php";
    $db = new DB;

    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
        header('Location: login.html');
    }

    $id_anketa = $_GET["id"];
    if (empty($id_anketa)) {
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
                <h1>Анкета</h1>
                <div class="block_info">
                        <?php
                            $data = $db->get_info_from_anketa($id_anketa);
                            $name_vacans = $db->get_name_vacans($data['id_post']);
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
                </div>
                <div class='btns'>
                    <a class='odobr'>Одобрить</a>
                    <a href="change_anketa.php?id=<?php echo $id_anketa; ?>" class='change'>Изменить</a>
                    <a class='otmena'>Отклонить</a>
                </div>
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
                                alert("Произошла ошибка, попробуйте позже.");
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
                                alert("Произошла ошибка, попробуйте позже.");
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