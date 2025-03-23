<?php
    require_once("../../db_credentials.php");

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
    }

    $errors = [];
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION["user_name"]);

    header("Location: login.php");
    exit();
?>