<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    require_once(ROOT_PATH . PRIVATE_PATH . "/functions/functions.php");

    echo '<style>'; 
    include ROOT_PATH . PUBLIC_PATH."/css/Formstyle.css";
    echo '</style>';

    if (isset($_SESSION['user_name'])) {
        $user_name = $_SESSION['user_name'];
        if(check_user_type($connection, $user_name) == "adopter"){
            header("Location: ../adopter/adopter_dashboard.php");
        } else{
            header("Location: ../provider/provider_dashboard.php");
        }
    }
    
    

    require_once(ROOT_PATH . SHARED_PATH.'/header.php');
    $user_name = '';
    $password = '';

    // if(isset($_SESSION['user_name'])){
        
    //     header("Location: welcome.php");
    //     exit();
    // }

   

    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!empty($_POST['user_name']) && !empty($_POST["password"])){
            $user_query = "SELECT password FROM user WHERE user_name = '" . $_POST['user_name'] . "'";
            $user_res = mysqli_query($connection, $user_query);
            if(mysqli_num_rows($user_res) != 0){
                $password = mysqli_fetch_assoc($user_res)['password'];
                //$row = mysqli_fetch_assoc($user_res)['user_type'];

                if(password_verify($_POST['password'], $password)){
                    $_SESSION['user_name'] = $_POST['user_name'];
                        $type_query = "SELECT user_type FROM user WHERE user_name = '" . $_POST['user_name'] . "'";
                        $type_res = mysqli_query($connection, $type_query);
                        $userType = mysqli_fetch_assoc($type_res)['user_type'];
                        echo $userType;
                        if($userType == 'provider'){
                            header("Location: ../provider/provider_dashboard.php");
                            // header("location: ../../pages/homepage.php");
                            //header(PUBLIC_PATH."/staff/provider/provider_dashboard.php");
                        }
                        else if($userType == 'adopter'){
                            header("Location: ../adopter/adopter_dashboard.php");
                            // header("location: ../../pages/homepage.php");
                            //header(PUBLIC_PATH."/staff/adopter/adopter_dashboard.php");
                        }
                    exit();
                }else{
                    array_push($errors, "The entered password do not match our record");
                }
            }else{
                array_push($errors, "The account does not exist, Please create a new Account!");
            }
        }else{
            array_push($errors, "Username or password field is not filled");
        }
    }

?>


    <body>
        <h1>Login</h1>

        <form method = "POST", action="login.php">
            <label>Username:</label><br>
            <input type="text" name="user_name" value=""/><br>
            <label>Password</label><br>
            <input type="text" name="password" value=""/><br>
            <input type="submit" value="Login"/>
        </form>
        <form action="register.php">
            <input type="submit" value="Create New Account">
        </form>

<?php require_once(ROOT_PATH . SHARED_PATH.'/footer.php');?>
