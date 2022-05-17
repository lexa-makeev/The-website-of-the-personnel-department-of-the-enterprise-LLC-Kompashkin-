<?php
    include "hrlib.php";
    $db = new DB;

    $login = $_POST["login"];
    $pass = $_POST["pass"];
    $reppass = $_POST["reppass"];
    $true_login = preg_match("/\S{2,}@\S+\.\S+/", $login);

    if (!empty($login) && !empty($pass) && !empty($reppass) && $pass == $reppass && $true_login == 1) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $date = date('Y-m-d H:i:s', time());
        $result = $db->registration($login, $hash, $date);
        if ($result == 1) {
            echo 3;
            exit();
        }
        else if ($result == 2) {
            echo 4;
            exit();
        }
        else {
            echo 2;
            exit();
        }
        // $stmt= $DBH->prepare("INSERT INTO new_users (id_user, mail, pass) VALUES (NULL,?,?)"); 
        // try {
        //     $res = $stmt->execute([$login, $hash]);
        // } catch (PDOException $e) {
        //     echo 4;
        //     exit();
        // }
        // if ($res > 0) {
        //     echo 3;
        //     // header('Location: login.html');
        //     exit();
        // }
        // else {
        //     echo 2;
        //     exit();
        // }
    }
    else {
        echo 1;
        exit();
    }
?>