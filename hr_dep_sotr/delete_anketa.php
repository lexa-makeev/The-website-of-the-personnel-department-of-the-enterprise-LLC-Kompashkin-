<?php
    include "hrlib.php";
    $db = new DB;

    $id = $_POST["id"];

    if (!empty($id)) {
        if ($db->cancel_anketa($id) == 1) {
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