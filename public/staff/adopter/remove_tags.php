<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    if(!isset($_SESSION['user_name'])){
        header(PUBLIC_PATH."/staff/general/login.php");
        exit();
      }
      
      $user_name = $_SESSION['user_name'];

      // Fetch user id based on username
      $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
      $userResult = mysqli_query($connection, $userQuery);
      $userData = mysqli_fetch_assoc($userResult);
      $user_id = $userData['user_id'];

    if(isset($_GET['edit'])){
        $tag_id = $_GET['edit'];
    } 

    $removeQuery = "DELETE FROM preferences WHERE user_id = '$user_id' AND tag_id = '$tag_id'";
    $remove = mysqli_query($connection, $removeQuery);
    if(!$remove){
        echo "Remove Failed!";
    }
    else{
        header("Location: adopter_dashboard.php");
    }
?>