<?php require_once(ROOT_PATH . PRIVATE_PATH . "/functions/functions.php") ?>


    
<?php
    if(isset($_SESSION['user_name'])){
        $user_name = $_SESSION['user_name'];
        $type_query = "SELECT user_type, profile_photo FROM user WHERE user_name = '" . $user_name. "'";
        $type_res = mysqli_query($connection, $type_query);

        // Check if the query is successful and contains at least one row
        if ($type_res && mysqli_num_rows($type_res) > 0) {
            $userData = mysqli_fetch_assoc($type_res);  
            $userType = $userData['user_type'];        
            $photo = $userData['profile_photo'];        
        } else {
            echo "No user found or query failed.";
        }
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
            <?php echo '<a class="logo" href="' . PUBLIC_PATH . '/pages/homepage.php"> 🐾 FurEver </a>';?>
            <div>
                <?php echo '<a href="' . PUBLIC_PATH . '/pages/homepage.php"> Homepage </a>';?>
                <?php echo '<a href="' . PUBLIC_PATH . '/pages/homepage.php#trending"> Pets </a>';?>
                <?php echo '<a href="' . PUBLIC_PATH . '/pages/about_us.php">About Us</a>';?>
                <?php
                    if(isset($_SESSION['user_name'])){
                        if($userType == 'provider'){
                            echo '<a href =' . PUBLIC_PATH . '/staff/provider/provider_dashboard.php' .' id="profile-photo-link">';
                            echo '<img src="' . PUBLIC_PATH . '/images/profilephoto/' . $photo . '" alt="Profile Photo" class="profile-photo">';
                            echo '</a>';
                        }
                        else if($userType == 'adopter'){
                            echo '<a href =' . PUBLIC_PATH . '/staff/adopter/adopter_dashboard.php' .' id="profile-photo-link">';
                            echo '<img src="' . PUBLIC_PATH . '/images/profilephoto/' . $photo . '" alt="Profile Photo" class="profile-photo">';
                            echo '</a>';
                        }
                    } else {
                        echo '<a href =' . PUBLIC_PATH . '/staff/general/login.php' .' id="login">Login</a>';
                    }
                ?>
            </div>
        </nav>
    </header>
<!--header ends here-->


