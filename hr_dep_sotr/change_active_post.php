<?php
    include "hrlib.php";
    $db = new DB;

    $id = $_POST["id"];
    $active = $_POST["active"];

    if (isset($id) && isset($active)) {
        if ($db->change_active($id, $active) == 1) {
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