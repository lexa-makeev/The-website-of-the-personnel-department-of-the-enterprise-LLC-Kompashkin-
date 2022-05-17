<?php
    include "hrlib.php";
    $db = new DB;

    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
        header('Location: login.html');
    }
    if ($db->check_anketa($id)) {
        header('Location: ankets.php');
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
        <link rel="stylesheet" href="css/podacha.css">
        <title>Подать анкету</title>
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
                            <a class="ankets" href="ankets.php">Анкеты</a>
                        </li>
                        <li>
                            <a class="send_anket" href="#">Подать анкету</a>
                        </li>
                    </ul>
                </nav>
                <p class="name"><?php echo $db->get_name($id); ?></p>
            </div>
        </header>
        <section>
            <div class="container">
                <h1>Подача анкеты</h1>
            </div>
            <div class="block_form">
                    <div class="pole">
                        <div class="container">
                            <label for="fam">Ваша фамилия</label>
                            <input type="text" name="fam" id="fam" placeholder="Петров">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="name">Ваша имя</label>
                            <input type="text" name="name" id="name" placeholder="Боня">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="otch">Ваша отчество</label>
                            <input type="text" name="otch" id="otch" placeholder="Юрьевна">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="date_birthday">Дата рождения</label>
                            <input type="date" name="date_birthday" id="date_birthday" placeholder="11.12.2000">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="pol">Пол</label>
                            <select name="pol" id="pol">
                                <option value="0">Женский</option>
                                <option value="1">Мужской</option>
                            </select>
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="mesto_rojdenia">Место рождения</label>
                            <input type="text" name="mesto_rojdenia" id="mesto_rojdenia" placeholder="г. Москва">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="grajdanstvo">Гражданство</label>
                            <input type="text" name="grajdanstvo" id="grajdanstvo" placeholder="Россия">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="obrazovanie">Образование</label>
                            <input type="text" name="obrazovanie" id="obrazovanie" placeholder="Высшее недополненное">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="telephone">Телефон</label>
                            <input type="text" name="telephone" id="telephone" placeholder="89173124141">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="posts">Желаемая вакансия</label>
                            <select name="posts" id="posts">
                                <?php
                                    $all_vacans = $db->get_active_vacans();
                                    foreach ($all_vacans as $key => $value) {
                                        echo "<option value='".$value["id_post"]."'>".$value["name_post"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="resume">Резюме</label>
                            <textarea name="resume" id="resume" placeholder="Имею навыки торговли"></textarea>
                        </div>
                    </div>
                    <button type="submit">Подать анкету</button>
            </div>
        </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function(){
            $("button").click(function(event){
                event.preventDefault();
                $("button").attr('disabled', 'disabled');
                setTimeout(function () { $("button").removeAttr('disabled'); }, 2000);
                var data = $('.block_form input, .block_form textarea, .block_form select').serialize();
                $.ajax({
                    type: "POST",
                    url: "new_anketa.php",
                    data: data,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            case "2":
                                alert("Произошла ошибка, попробуйте позже.");
                                break;
                            case "3":
                                alert("Вы успешно подали анкету.");
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
            });
        });
    </script>
</html>