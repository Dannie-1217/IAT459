<?php require_once("initialization.php") ?>
<?php
    if (isset($_SESSION['user_name'])) {
        $user_name = $_SESSION['user_name'];

        $user_query = "SELECT user_id FROM user WHERE user_name = '" . $user_name . "'";
        $user_res = mysqli_query($connection, $user_query);
        $user_id = mysqli_fetch_assoc($user_res)['user_id'];
        $pet_id = $_SESSION['pet_id'];
        echo $pet_id;

        $add_favorite = "INSERT INTO favorites(user_id, pet_id) 
                    VALUES($user_id, $pet_id)";
        $add_res = mysqli_query($connection, $add_favorite);

        echo $user_id;
        echo $pet_id;

        if(!$add_res){
            echo"query faled!";
            exit;
        }
        else{
            header("Location: ../../public/pages/pet_information.php");
        }
    }
    else{
        header("Location: ../../public/staff/general/login.php");
    }
?>