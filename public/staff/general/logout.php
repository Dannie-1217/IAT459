<?php require_once("../../../private/functions/initialization.php") ?>

<?php

    unset($_SESSION["user_name"]);

    header("Location: ../../pages/homepage.php");
    exit();
?>