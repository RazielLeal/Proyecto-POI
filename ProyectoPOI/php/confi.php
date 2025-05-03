<?php
    $db_server = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "phpchatapp_db";

    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    if($conn){
        //cho "Connected to the database";
    }else{
        //echo "Failed to connect to the database";
    }
?>