<?php
    include "hrlib.php";
    $db = new DB;

    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
        header('Location: login.html');
    }

    $params = [];
    $params["id_user"] = $id;
    $params["fam"] = $_POST["fam"];
    $params["name"] = $_POST["name"];
    $params["otch"] = $_POST["otch"];
    $params["date_birthday"] = $_POST["date_birthday"];
    $params["pol"] = $_POST["pol"];
    $params["mesto_rojdenia"] = $_POST["mesto_rojdenia"];
    $params["grajdanstvo"] = $_POST["grajdanstvo"];
    $params["obrazovanie"] = $_POST["obrazovanie"];
    $params["telephone"] = $_POST["telephone"];
    $params["posts"] =  $_POST["posts"];
    $params["resume"] =  $_POST["resume"];

    $params["otch"] = $params["otch"] == "" ? "Отсутствует" : $params["otch"];
    $params["obrazovanie"] = $params["obrazovanie"] == "" ? "Отсутствует" : $params["obrazovanie"];

    if (isset($params["fam"]) && isset($params["name"]) && 
    isset($params["date_birthday"]) && isset($params["pol"]) &&
    isset($params["mesto_rojdenia"]) && isset($params["grajdanstvo"]) &&
    isset($params["telephone"]) && isset($params["posts"]) &&
    isset($params["resume"])) {
        $result = $db->create_anketa($params);
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