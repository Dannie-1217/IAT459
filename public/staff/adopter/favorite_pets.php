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
            <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
            <a href="../general/logout.php" class="nav-btn logout">Logout</a>
        </div>

        <div class="dashboard-container">
            <h1>Pets You May Like</h1>
            <div class="card-recent">
                <div class="card-recent-header">Recent Liked Pets:</div>

                <ul class="recent-list">
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

                        $recentPetsQuery = "SELECT pet.pet_name, pet.post_date, pet.pet_id
                                        FROM favorites 
                                        JOIN pet ON favorites.pet_id = pet.pet_id 
                                        WHERE favorites.user_id = '$user_id' 
                                        ORDER BY pet.post_date DESC";
                        $recentPetsResult = mysqli_query($connection, $recentPetsQuery);

                        if(!$recentPetsResult){
                                echo"query faled!";
                                exit;
                            }

                            if(mysqli_num_rows($recentPetsResult) != 0){
                                while($row = mysqli_fetch_assoc($recentPetsResult)){
                                    $pet_id = $row['pet_id'];
                                    echo "<a href='../../pages/pet_information.php?edit=$pet_id' id='link1'><li class='list-group-item'>";
                                    echo "<td>". $row['pet_name']. "</td>";  
                                    echo " -- Post On: ";
                                    echo "<td>". $row['post_date']. "</td>";   
                                    echo"</li></a>";
                                }
                            }
                            else{
                                echo"<tr>Result is empty!</tr>";
                            };
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