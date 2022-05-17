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
        <link rel="stylesheet" href="css/vacans.css">
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
                $data = $db->get_all_vacans();
                if ($data != null) {
                    foreach ($data as $key => $value) {
                        $active = $value["active"] == 0 ? "Открыть вакансию" : "Закрыть вакансию";
                        echo '<div class="block_status">
                                <div class="container">
                                    <p class="id">'.$value["name_post"].'</p>
                                    <a data-active='.$value["active"].' data-id='.$value["id_post"].' class="change">'.$active.'</a>
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
        $(document).ready(function(){
            $("a.change").click(function(event){
                event.preventDefault();
                var id_post =$(this).attr("data-id");
                var active =$(this).attr("data-active");
                var text = "Вы уверены, что хотите изменить открыть вакансию?";
                var text_confirm = "Вакансия успешно открыта.";
                if (active == 1) {
                    text = "Вы уверены, что хотите изменить закрыть вакансию?";
                    text_confirm = "Вакансия успешно закрыта.";
                }
                var result = confirm(text);
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: "change_active_post.php",
                        data: "id=" + id_post + "&active=" + active,
                        success: function (result) {
                            console.log(result);
                            switch (result) {
                                case "0":
                                    alert("Сбой подключения, попробуйте позже.");
                                    break;
                                case "3":
                                    alert(text_confirm);
                                    window.location.href = "vacans.php";
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