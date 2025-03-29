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

    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
    }

    if( isset($_GET['decision'])) $decision=trim($_GET['decision']); 

    if(!empty($decision)){
        if($decision == 'Approve'){
            $update_query = "UPDATE adoption_records SET status = 'Approve' WHERE pet_id = ".$id;
            mysqli_query($connection, $update_query);
            header("Location: provider_dashboard.php");
            exit();
        }
        else if($decision == 'Decline'){
            $update_query = "UPDATE adoption_records SET status = 'Decline' WHERE pet_id = ".$id;
            mysqli_query($connection, $update_query);
            header("Location: provider_dashboard.php");
            exit();
        }
        else{
            header("Location: provider_dashboard.php");
            exit();
        }
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
    }  

    $user_name = $_SESSION['user_name'];

    $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['user_id'];

    $RequestQuery = "SELECT pet_id, adopted_before, other_pets, suitable_living_space, reason_for_adoption, status FROM adoption_records WHERE pet_id = ".$id;
    $RequestResult = mysqli_query($connection, $RequestQuery);
    
    if(!$RequestResult){
        echo"query faled!";
        exit;
    }

    if(mysqli_num_rows($RequestResult) != 0){
        echo"<table class='resultTable'><tr>";          
            echo "<td class='tableGrid'><p class='tableHeader'>Pet ID</p></td>";  
            echo "<td class='tableGrid'><p class='tableHeader'>Adopted Before</p></td>";   
            echo "<td class='tableGrid'><p class='tableHeader'>Other Pets</p></td>";
            echo "<td class='tableGrid'><p class='tableHeader'>Suitable Living Space</p></td>";      
            echo "<td class='tableGrid'><p class='tableHeader'>Reason for Adoption</p></td>";   
            echo "<td class='tableGrid'><p class='tableHeader'>Status</p></td>";   
        echo "</tr><tr>";
        while($row = mysqli_fetch_assoc($RequestResult)){
            $pet_id = $row['pet_id'];
            echo "<td class='tableGrid'>". $row['pet_id']. "</td>";  
            echo "<td class='tableGrid'>". $row['adopted_before']. "</td>";  
            echo "<td class='tableGrid'>". $row['other_pets']. "</td>";  
            echo "<td class='tableGrid'>". $row['suitable_living_space']. "</td>";  
            echo "<td class='tableGrid'>". $row['reason_for_adoption']. "</td>";  
            echo "<td class='tableGrid'>". $row['status']. "</td>";   
            echo"</tr>";
        }
        echo"</table>";
    }
    else{
        echo"<tr>Result is empty!</tr>";
    }

    echo"<form action='request_processing.php'>
            <label>Your Decision:</label><br>
            <input type='radio' name='decision' value='Later' checked> Later<br>
            <input type='radio' name='decision' value='Approve' required> Approve<br>
            <input type='radio' name='decision' value='Decline' required> Decline<br><br>";
            $_SESSION['id'] = $id;

    echo"       <input type='submit' value='Make Decision'>
        </form>";
?>