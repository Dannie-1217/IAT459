<?php require_once("../../private/functions/initialization.php") ?>

<html>
<head>
    <!--Add title for the website.-->
    <title>FurEver Friends</title>
    <style>
        a { color:#E2EAF4; text-decoration: none;}
    </style>
</head>

<body>
    <!--Add text and nav button for the header.-->
    <table style="height:85%; width:100%;border-spacing:0px">
    <tr style="height:100px;background-color:#1E3755">
        <th style="font-family:verdana;font-size:66px;color:#E2EAF4;text-align:left">FurEver Friends</th>
    </tr>
    <?php
    if(isset($_SESSION['user_name'])){
        $user_name = $_SESSION['user_name'];
        $type_query = "SELECT user_type FROM user WHERE user_name = '" . $user_name. "'";
        $type_res = mysqli_query($connection, $type_query);
        $userType = mysqli_fetch_assoc($type_res)['user_type'];
        //echo $userType;
        if($userType == 'provider'){
            echo'
                <tr height="30" bgcolor="#1E3755">
                    <td style="font-family:verdana;font-size:24px;color:#E2EAF4;" id="header">
                        <strong><a href= "../../public/pages/homepage.php"> Homepage </a> |
                                <a href= "../../public/staff/general/login.php"> Log in/Sign up </a> 
                                <a href= "../../public/pages/about_us.php"> About Us </a> 
                                <a href= "../../public/staff/provider/provider_dashboard.php"> Account Information </a> 
                    </td>
                <tr bgcolor="FFFFFF">
                <td >';
        }
        else if($userType == 'adopter'){
            echo'
                <tr height="30" bgcolor="#1E3755">
                    <td style="font-family:verdana;font-size:24px;color:#E2EAF4;" id="header">
                        <strong><a href= "../../public/pages/homepage.php"> Homepage </a> |
                                <a href= "../../public/staff/general/login.php"> Log in/Sign up </a> 
                                <a href= "../../public/pages/about_us.php"> About Us </a> 
                                <a href= "../../public/staff/adopter/adopter_dashboard.php"> Account Information </a> 
                    </td>
                <tr bgcolor="FFFFFF">
                <td >';
        }
    }
    else{
        echo'
        <tr height="30" bgcolor="#1E3755">
            <td style="font-family:verdana;font-size:24px;color:#E2EAF4;" id="header">
                <strong><a href= "../../public/pages/homepage.php"> Homepage </a> |
                        <a href= "../../public/staff/general/login.php"> Log in/Sign up </a> 
                        <a href= "../../public/pages/about_us.php"> About Us </a> 
            </td>
        <tr bgcolor="FFFFFF">
        <td >';
    }
    ?>
<!--header ends here-->


