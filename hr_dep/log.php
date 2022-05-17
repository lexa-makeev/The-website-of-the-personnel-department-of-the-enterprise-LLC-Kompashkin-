<?php
    include "hrlib.php";
    $db = new DB;

    $login = $_POST["login"];
    $pass = $_POST["pass"];

    if (!empty($login) && !empty($pass)) {
        // $hash = password_hash($pass, PASSWORD_DEFAULT);
        $data = $db->check_login($login);
        if ($data != null) {
            if (password_verify($pass, $data["pass"])) {
                session_start();
                $_SESSION["id"] = $data["id_user"];
                echo 3;
                // header('Location: index.php');
                exit();
            }
            else {
                echo 1;
                exit();
            }
        }
        else {
            echo 1;
            exit();
        }
    }
    else {
        echo 1;
        exit();
    }
?>