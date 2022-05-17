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
     
    $data = $db->get_info_change_anketa($id_anketa);
    if ($data != null) {
        $fam = $data["fam"];
        $name = $data["name"];
        $otch = $data["otch"];
        $date_birthday = $data["date_birthday"];
        $pol = $data["pol"];
        $mesto_rojdenia = $data["mesto_rojdenia"];
        $grajdanstvo = $data["grajdanstvo"];
        $obrazovanie = $data["obrazovanie"];
        $telephone = $data["telephone"];
        $resume = $data["resume"];
    }
    else {
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
        <link rel="stylesheet" href="css/change_anketa.css">
        <title>Подать анкету</title>
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
                <h1>Изменение анкеты</h1>
            </div>
            <div class="block_form">
                    <div class="pole">
                        <div class="container">
                            <label for="fam">Ваша фамилия</label>
                            <input type="text" name="fam" id="fam" placeholder="Петров" value="<?php echo $fam; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="name">Ваша имя</label>
                            <input type="text" name="name" id="name" placeholder="Боня" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="otch">Ваша отчество</label>
                            <input type="text" name="otch" id="otch" placeholder="Юрьевна" value="<?php echo $otch; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="date_birthday">Дата рождения</label>
                            <input type="date" name="date_birthday" id="date_birthday" placeholder="11.12.2000" value="<?php echo $date_birthday; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="pol">Пол</label>
                            <select name="pol" id="pol">
                                <?php
                                    if ($pol == 1) {
                                        echo '<option value="0">Женский</option>
                                        <option value="1" selected>Мужской</option>';
                                    }
                                    else {
                                        echo '<option value="0" selected>Женский</option>
                                        <option value="1">Мужской</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="mesto_rojdenia">Место рождения</label>
                            <input type="text" name="mesto_rojdenia" id="mesto_rojdenia" placeholder="г. Москва" value="<?php echo $mesto_rojdenia; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="grajdanstvo">Гражданство</label>
                            <input type="text" name="grajdanstvo" id="grajdanstvo" placeholder="Россия" value="<?php echo $grajdanstvo; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="obrazovanie">Образование</label>
                            <input type="text" name="obrazovanie" id="obrazovanie" placeholder="Высшее недополненное" value="<?php echo $obrazovanie; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="telephone">Номер телефона</label>
                            <input type="tel" name="telephone" id="telephone" placeholder="89318412341" value="<?php echo $telephone; ?>">
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="id_post">Желаемая вакансия</label>
                            <select name="id_post" id="id_post">
                                <?php
                                    $all_vacans = $db->get_active_vacans(); 
                                    foreach ($all_vacans as $key => $value) {
                                        if ($vacans == $value["id_post"]) {
                                            echo "<option selected value='".$value["id_post"]."'>".$value["name_post"]."</option>";
                                        }
                                        else {
                                            echo "<option value='".$value["id_post"]."'>".$value["name_post"]."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="pole">
                        <div class="container">
                            <label for="resume">Резюме</label>
                            <textarea placeholder="Коротко о себе" name="resume" id="resume"><?php echo $resume; ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id_anketa" value="<?php echo $id_anketa; ?>">
                    <button type="submit">Изменить анкету</button>
            </div>
        </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function(){
            $("button").click(function(event){
                event.preventDefault();
                var data = $('.block_form input, .block_form select, .block_form textarea').serialize();
                var result = confirm("Вы уверены, что хотите изменить анкету?");
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: "change_anketa_file.php",
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
                                    alert("Вы успешно изменили анкету.");
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