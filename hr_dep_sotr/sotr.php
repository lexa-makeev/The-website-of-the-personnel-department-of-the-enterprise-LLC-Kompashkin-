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
        <link rel="stylesheet" href="css/sotr.css">
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
                <h1>Сотрудники</h1>
            </div>
            <?php
                $data = $db->get_all_sotr();
                if ($data != null) {
                    echo '<div class="head_sotr container"> 
                            <p class="fam_head" onclick="clickFam();">Фамилия</p>
                            <p class="name_head" onclick="clickName();">Имя</p>
                            <p class="middle_head" onclick="clickMiddle();">Отчество</p>
                            <p class="date_head" onclick="clickDate();">Дата рождения</p>
                            <p class="post_head" onclick="clickPost();">Должность</p>
                            <p class="zp_head" onclick="clickCash();">Зарплата</p>
                        </div>';
                        foreach ($data as $key => $value) {
                            $date = new DateTime($value["date_birthday"]);
                            echo '<div class="block_status">
                                <div class="container"> 
                                    <p>'.$value["fam"].'</p>
                                    <p>'.$value["name"].'</p>
                                    <p>'.$value["otch"].'</p>
                                    <p>'.$date->format('d.m.Y').'</p>
                                    <p>'.$value["name_post"].'</p>
                                    <p>'.$value["cash"].'руб</p>
                                </div>
                                <div class="btn container"> 
                                    <a href="sotr_info.php?id='.$value["id_sotr"].'">Посмотреть</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
            function clickFam(event){
                var add_class = "desk";
                var action = 1;
                if ($(".fam_head").hasClass("asc")) {
                    add_class = "desk";
                    action = 1;
                }
                else if ($(".fam_head").hasClass("desk")) {
                    add_class = "asc";
                    action = 2;
                }
                $.ajax({
                    type: "POST",
                    url: "sort.php",
                    data: "pole=fam&action="+ action,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            default:
                                $("section").html("<div class='container'><h1>Сотрудники</h1></div>"+result);
                                $(".fam_head").addClass(add_class);
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
            }
            function clickName(event){
                var add_class = "desk";
                var action = 1;
                if ($(".name_head").hasClass("asc")) {
                    add_class = "desk";
                    action = 1;
                }
                else if ($(".name_head").hasClass("desk")) {
                    add_class = "asc";
                    action = 2;
                }
                $.ajax({
                    type: "POST",
                    url: "sort.php",
                    data: "pole=name&action="+ action,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            default:
                                $("section").html("<div class='container'><h1>Сотрудники</h1></div>"+result);
                                $(".name_head").addClass(add_class);
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
            }
            function clickMiddle(event){
                var add_class = "desk";
                var action = 1;
                if ($(".middle_head").hasClass("asc")) {
                    add_class = "desk";
                    action = 1;
                }
                else if ($(".middle_head").hasClass("desk")) {
                    add_class = "asc";
                    action = 2;
                }
                $.ajax({
                    type: "POST",
                    url: "sort.php",
                    data: "pole=middle&action="+ action,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            default:
                                $("section").html("<div class='container'><h1>Сотрудники</h1></div>"+result);
                                $(".middle_head").addClass(add_class);
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
            }
            function clickDate(event){
                var add_class = "desk";
                var action = 1;
                if ($(".date_head").hasClass("asc")) {
                    add_class = "desk";
                    action = 1;
                }
                else if ($(".date_head").hasClass("desk")) {
                    add_class = "asc";
                    action = 2;
                }
                $.ajax({
                    type: "POST",
                    url: "sort.php",
                    data: "pole=date&action="+ action,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            default:
                                $("section").html("<div class='container'><h1>Сотрудники</h1></div>"+result);
                                $(".date_head").addClass(add_class);
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
            }
            function clickPost(event){
                var add_class = "desk";
                var action = 1;
                if ($(".post_head").hasClass("asc")) {
                    add_class = "desk";
                    action = 1;
                }
                else if ($(".post_head").hasClass("desk")) {
                    add_class = "asc";
                    action = 2;
                }
                $.ajax({
                    type: "POST",
                    url: "sort.php",
                    data: "pole=post&action="+ action,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            default:
                                $("section").html("<div class='container'><h1>Сотрудники</h1></div>"+result);
                                $(".post_head").addClass(add_class);
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
            }
            function clickCash(event){
                var add_class = "desk";
                var action = 1;
                if ($(".zp_head").hasClass("asc")) {
                    add_class = "desk";
                    action = 1;
                }
                else if ($(".zp_head").hasClass("desk")) {
                    add_class = "asc";
                    action = 2;
                }
                $.ajax({
                    type: "POST",
                    url: "sort.php",
                    data: "pole=cash&action="+ action,
                    success: function (result) {
                        switch (result) {
                            case "0":
                                alert("Сбой подключения, попробуйте позже.");
                                break;
                            case "1":
                                alert("Проверьте правильность введённых данных.");
                                break;
                            default:
                                $("section").html("<div class='container'><h1>Сотрудники</h1></div>"+result);
                                $(".zp_head").addClass(add_class);
                                break;
                        }
                    },
                    error: function (error) {

                    }
                });
            }
    </script>
</html>