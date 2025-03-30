<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    //Set CSS file.
    echo '<style>'; 
        include PUBLIC_PATH."/css/Formstyle.css"; 
    echo '</style>';

    if(!isset($_SESSION['user_name'])){
        header("Location: ../staff/general/login.php");
        exit();
    }

    $user_name = $_SESSION['user_name'];

    $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['user_id'];

    $adoptionRecordQuery = "SELECT pet_id, status FROM adoption_records WHERE user_id = '$user_id'";
    $adoptionRecordResult = mysqli_query($connection, $adoptionRecordQuery);
    
    if(!$adoptionRecordResult){
        echo"query faled!";
        exit;
    }

    if(mysqli_num_rows($adoptionRecordResult) != 0){
        echo"<table class='resultTable'><tr>";          
            echo "<td class='tableGrid'><p class='tableHeader'>Pet ID</p></td>";  
            echo "<td class='tableGrid'><p class='tableHeader'>Status</p></td>";   
        echo "</tr><tr>";
        while($row = mysqli_fetch_assoc($adoptionRecordResult)){
            $pet_id = $row['pet_id'];
            echo "<td class='tableGrid'><a href='request_processing.php?edit=$pet_id' id='link1'>". $row['pet_id']. "</a></td>";  
            echo "<td class='tableGrid'><a href='request_processing.php?edit=$pet_id' id='link1'>". $row['status']. "</a></td>";   
            echo"</tr>";
        }
        echo"</table>";
    }
    else{
        echo"<tr>Result is empty!</tr>";
    }

    echo"<form action='adopter_dashboard.php'>
            <input type='submit' value='back'>
    </form>";
?>