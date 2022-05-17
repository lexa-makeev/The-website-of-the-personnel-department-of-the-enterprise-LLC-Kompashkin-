<?php
    include "hrlib.php";
    $db = new DB;
 
    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
        header('Location: login.html');
    }

    $params = [];
    $params["id_anketa"] = $_POST["id_anketa"];
    $params["fam"] = $_POST["fam"];
    $params["name"] = $_POST["name"];
    $params["otch"] = $_POST["otch"];
    $params["date_birthday"] = $_POST["date_birthday"];
    $params["pol"] = $_POST["pol"];
    $params["grajdanstvo"] = $_POST["grajdanstvo"];
    $params["obrazovanie"] = $_POST["obrazovanie"];
    $params["telephone"] = $_POST["telephone"];
    $params["id_post"] =  $_POST["id_post"];
    $params["resume"] =  $_POST["resume"];

    $params["otch"] = $params["otch"] == "" ? "Отсутствует" : $params["otch"];
    $params["resume"] = $params["resume"] == "" ? "Отсутствует" : $params["resume"];

    if (isset($params["id_anketa"]) && isset($params["fam"]) && isset($params["name"]) && 
    isset($params["date_birthday"]) && isset($params["pol"]) && isset($params["grajdanstvo"]) && 
    isset($params["obrazovanie"]) && isset($params["telephone"]) && isset($params["id_post"]) &&
    isset($params["resume"])) {
        $result = $db->change_anketa($params);
        if ($result == 1) {
            echo 3;
            exit();
        }
        else {
            echo 2;
            exit();
        }
    }
    else {
        echo 1;
        exit();
    }
?>