<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/dashboard.css',
        PUBLIC_PATH . '/css/sidebar.css',
        PUBLIC_PATH . '/css/font.css',
        PUBLIC_PATH . '/css/grid.css',
        PUBLIC_PATH . '/css/footer.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
    ];

    require_once(ROOT_PATH . SHARED_PATH . '/header.php');

    require_once(ROOT_PATH . PRIVATE_PATH.'/functions/functions.php');  
?>

<body>
    <div class="dashboard-wrapper">
        <div class="sidebar-nav">
            <a href="adopter_dashboard.php" class="nav-btn">Dashboard</a>
            <a href="../../pages/homepage.php" class="nav-btn">Adopt New Pet</a>
            <a href="favorite_pets.php" class="nav-btn">Favorite Pets</a>
            <a href="adopter_records.php" class="nav-btn">Check Records</a>
            <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
            <a href="../general/logout.php" class="nav-btn logout">Logout</a>
        </div>

        <div class="dashboard-container">
            <h1>Your Adoption Records</h1>
            <div class="card-recent">
                <div class="card-recent-header"> Your Request Records and Status:</div>

                <ul class="recent-list">
                    <?php
                        if(!isset($_SESSION['user_name'])){
                            header("Location: ../staff/general/login.php");
                            exit();
                        }

                        $user_name = $_SESSION['user_name'];

                        $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
                        $userResult = mysqli_query($connection, $userQuery);
                        $userData = mysqli_fetch_assoc($userResult);
                        $user_id = $userData['user_id'];

                        $adoptionRecordQuery = "SELECT adoption_records.pet_id, pet.pet_name, pet.pet_type, pet.location, adoption_records.status FROM adoption_records 
                        JOIN pet ON adoption_records.petid = pet.pet_id
                        WHERE user_id = '$user_id'";
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
                    ?>
                 </ul>
            </div>
            <form action='adopter_dashboard.php'>
                <input class = 'back' type='submit' value='back'>
            </form>
        </div>
    </div>
    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>
</html>