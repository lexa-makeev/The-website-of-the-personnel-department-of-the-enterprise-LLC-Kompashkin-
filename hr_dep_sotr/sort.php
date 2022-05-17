<?php
    include "hrlib.php";
    $db = new DB;

    $pole = $_POST["pole"];
    $action = $_POST["action"];
    if (empty($pole) || empty($action)) {
        echo 1;
        exit();
    }
    $sort = "ASC";
    if ($action == 2) {
        $sort = "DESC";
    }

    switch ($pole) {
        case 'fam':
            $pole_col = "anketa.fam";
            break;
        case 'name':
            $pole_col = "anketa.name";
            break;
        case 'middle':
            $pole_col = "anketa.otch";
            break;
        case 'date':
            $pole_col = "anketa.date_birthday";
            break;
        case 'post':
            $pole_col = "posts.name_post";
            break;
        case 'cash':
            $pole_col = "posts.cash";
            break;
        default:
            $pole_col = "anketa.fam";
            break;
    }
    $data = $db->sort_all_sotr($pole_col, $sort);
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