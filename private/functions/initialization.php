<?php
    require_once("db_credentials.php");

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(mysqli_connect_error()){
        echo mysqli_connect_error();
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Assign file paths to PHP constants
    define("PRIVATE_PATH", '/IAT459/private');
    define("PUBLIC_PATH", '/IAT459/public');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');

    $errors = [];
?>