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

      $recentPetsQuery = "SELECT pet.pet_name, pet.post_date 
                    FROM favorites 
                    JOIN pet ON favorites.pet_id = pet.pet_id 
                    WHERE favorites.user_id = '$user_id' 
                    ORDER BY pet.post_date DESC 
                    LIMIT 3";
      $recentPetsResult = mysqli_query($connection, $recentPetsQuery);

      if(!$recentPetsResult){
            echo"query faled!";
            exit;
        }

        if(mysqli_num_rows($recentPetsResult) != 0){
            echo"<table class='resultTable'><tr>";          
                echo "<td class='tableGrid'><p class='tableHeader'>Pet Name</p></td>";  
                echo "<td class='tableGrid'><p class='tableHeader'>Post Date</p></td>";   
            echo "</tr><tr>";
            while($row = mysqli_fetch_assoc($recentPetsResult)){
                echo "<td class='tableGrid'>". $row['pet_name']. "</td>";  
                echo "<td class='tableGrid'>". $row['post_date']. "</td>";   
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