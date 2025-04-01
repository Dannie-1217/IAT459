<?php require_once(ROOT_PATH . PRIVATE_PATH . "/functions/functions.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Add title for the website.-->
    <meta charset="UTF-8">
    <title>FurEver Friends</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #header a { color:#E2EAF4; text-decoration: none; padding-right:30px}
        #header {background-color:#1E3755; color:#E2EAF4}
        #header h1{font-size:66px; margin-bottom: 0}
        #header nav{color:#E2EAF4; font-size:30px; text-align:left}
        #header nav ul{padding-inline-start: 0px; margin-top:0}
        .footer-container {background-color:#1E3755; color:#E2EAF4}
    </style>
</head>

<body>
    <div id="header">
        <h1>FurEver Friends</h1>
    <?php
    echo '<nav><ul>';
    echo '<a href =' . PUBLIC_PATH . '/pages/homepage.php' .'> Homepage </a>';
    if(isset($_SESSION['user_name'])){
        $user_name = $_SESSION['user_name'];
        $type_query = "SELECT user_type FROM user WHERE user_name = '" . $user_name. "'";
        $type_res = mysqli_query($connection, $type_query);
        $userType = mysqli_fetch_assoc($type_res)['user_type'];

        if($userType == 'provider'){
            echo '<a href =' . PUBLIC_PATH . '/staff/provider/provider_dashboard.php' .'> Log in/Sign up </a>';
        }
        else if($userType == 'adopter'){
            echo '<a href =' . PUBLIC_PATH . '/staff/adopter/adopter_dashboard.php' .'> Log in/Sign up </a>'; 
        }
    }else{
        echo '<a href =' . PUBLIC_PATH . '/staff/general/login.php' .'> Log in/Sign up </a>';
    }
    echo '<a href =' . PUBLIC_PATH . '/pages/about_us.php' .'> About Us </a>';
    echo  '</ul></nav>';
    ?>
    </div>
<!--header ends here-->


