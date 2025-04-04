<?php require_once(ROOT_PATH . PRIVATE_PATH . "/functions/functions.php") ?>


    
<?php
    if(isset($_SESSION['user_name'])){
        $user_name = $_SESSION['user_name'];
        $type_query = "SELECT user_type FROM user WHERE user_name = '" . $user_name. "'";
        $type_res = mysqli_query($connection, $type_query);
        $userType = mysqli_fetch_assoc($type_res)['user_type'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurEver Friends</title>
    
    <?php
        if(isset($page_styles) && is_array($page_styles)){
            foreach($page_styles as $style){
                echo '<link rel="stylesheet" href="' . $style . '">';
            }
        }
    ?>
</head>

<body>
    <header>
        <nav>
            <a class="logo" href="../../public/pages/homepage.php">🐾 FurEver</a>
            <div>
                <a href="../../public/pages/homepage.php">Pets</a>
                <a href="../../public/pages/about_us.php">About Us</a>
                <?php
                    if(isset($_SESSION['user_name'])){
                        if($userType == 'provider'){
                            echo '<a href =' . PUBLIC_PATH . '/staff/provider/provider_dashboard.php' .' id=login> Login </a>';
                        }
                        else if($userType == 'adopter'){
                            echo '<a href =' . PUBLIC_PATH . '/staff/adopter/adopter_dashboard.php' .' id=login> Login </a>'; 
                        }
                    }else{
                        echo '<a href =' . PUBLIC_PATH . '/staff/general/login.php' .' id=login> Login </a>';
                    }
                ?>
            </div>
        </nav>
    </header>
<!--header ends here-->


