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

<?php
      if(!isset($_SESSION['user_name'])){
        header(PUBLIC_PATH."/staff/general/login.php");
        exit();
      }

      $placeholder="Type to search or add new...";
      
      $user_name = $_SESSION['user_name'];

      // Fetch user id based on username
      $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
      $userResult = mysqli_query($connection, $userQuery);
      $userData = mysqli_fetch_assoc($userResult);
      $user_id = $userData['user_id'];

      // Get count of saved pets by the user
      $petCountQuery = "SELECT COUNT(*) AS favorite_pet_count FROM favorites WHERE user_id = '$user_id'";
      $petCountResult = mysqli_query($connection, $petCountQuery);
      $petCount = mysqli_fetch_assoc($petCountResult)['favorite_pet_count'];

      // Get count of adoption records for this provider
      $adoptionRequestCountQuery = "SELECT COUNT(*) AS adoption_count FROM adoption_records WHERE user_id = '$user_id'";
      $adoptionRequestCountResult = mysqli_query($connection, $adoptionRequestCountQuery);
      $adoptionRequestCount = mysqli_fetch_assoc($adoptionRequestCountResult)['adoption_count'];

      // Get recent 3 pet liked by this provider
      $recentPetsQuery = "SELECT pet.pet_name, pet.post_date 
                    FROM favorites 
                    JOIN pet ON favorites.pet_id = pet.pet_id 
                    WHERE favorites.user_id = '$user_id' 
                    ORDER BY pet.post_date DESC 
                    LIMIT 3";
      $recentPetsResult = mysqli_query($connection, $recentPetsQuery);

      //Process Tags
      if($_SERVER["REQUEST_METHOD"] === "POST") {
        $tags = isset($_POST['tags']) ? $_POST['tags']:[];
        $tag_id;
        //mysqli_begin_transaction($connection);

            $tagQuery = "SELECT tag_id FROM tags WHERE content = '$tags'";
            $tagResult = mysqli_query($connection, $tagQuery);

            if(mysqli_num_rows($tagResult)>0){
                $tagRow = mysqli_fetch_assoc($tagResult);
                $tag_id = $tagRow['tag_id'];
            } else{
                $insertTag = "INSERT INTO tags (content) VALUES ('$tags')";
                $insertTag_res = mysqli_query($connection, $insertTag);
                if(!$insertTag_res){
                    array_push($errors, "Failed to inset new tag: " . mysqli_error($connection));
                } else{
                    $tag_id = mysqli_insert_id($connection);
                }
            }

            $addTag = "INSERT INTO preferences(user_id, tag_id) VALUES ($user_id, $tag_id)";
            $addRes = mysqli_query($connection, $addTag);
            if(!$addRes){
                array_push($errors, "Failed to associate tag with pet: " . mysqli_error($connection));
            }
        
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Provider Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#tag_input").on("input",function(){
                    let query = $(this).val();
                    if(query.length > 1){
                        $.ajax({
                            url:"fetch_tags.php",
                            method:"POST",
                            data:{query: query},
                            success: function(data){
                                $("#tag_suggestions").html(data);
                            }
                        });
                    }else{
                        $("#tag_suggestions").html("");
                    }
                });
            });

            function addTag(tagName){
                document.getElementById('tag_input').value=tagName;
            }
        </script>
</head>

<body>
    <div class="dashboard-wrapper">
        <div class="sidebar-nav">
            <a href="adopter_dashboard.php" class="nav-btn">Dashboard</a>
            <a href="../../pages/homepage.php#trending" class="nav-btn">Adopt New Pet</a>
            <a href="favorite_pets.php" class="nav-btn">Favorite Pets</a>
            <a href="adopter_records.php" class="nav-btn">Check Records</a>
            <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
            <a href="../general/logout.php" class="nav-btn logout">Logout</a>
        </div>

        <div class="dashboard-container">
            <h1>Welcome, <?= htmlspecialchars($user_name) ?></h1>

            <!-- Stats Section -->
            <div class="stats-row">
                <a href="favorite_pets.php" class="stat-card">
                                <h5>Favorite Pets</h5>
                                <p class="card-text fs-2"><?= $petCount ?></p>
                </a>    
                <a href="adopter_records.php" class="stat-card bg-success">
                            <h5 class="card-title">Adoption Records</h5>
                            <p class="card-text fs-2"><?= $adoptionRequestCount ?></p>
                </a>
            </div>

            <!-- Recent Activity Section -->
            <div class="card-recent">
                <div class="card-recent-header">Recent Liked Pets</div>
                <ul class="recent-list">
                    <?php while ($pet = mysqli_fetch_assoc($recentPetsResult)) : ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($pet['pet_name']) ?> - Posted on <?= htmlspecialchars($pet['post_date']) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Add Tags-->
            <div class="card-tag">
                <div class="add-tag">
                    <form action="adopter_dashboard.php" method="POST" enctype="multipart/form-data">
                        <label>Add Tags: </label><br>
                        <?php
                            echo '<input type="text" id="tag_input" name="tags" placeholder='. $placeholder.'>';
                        ?>
                        <input type="submit" value='Add'/>
                        <div id="tag_suggestions"></div>
                    </form>
                </div>
                    <div class="tag_list"><p>Tag List:</p></div>
                    <?php
                        $taglistQuery = "SELECT tags.content, tags.tag_id FROM tags LEFT JOIN preferences ON preferences.tag_id = tags.tag_id WHERE preferences.user_id = '$user_id'";
                        $taglistResult = mysqli_query($connection, $taglistQuery);

                        if(mysqli_num_rows($taglistResult)>0){
                            while($row = mysqli_fetch_assoc($taglistResult)){
                                $tag_id = $row['tag_id'];
                                echo "
                                      <div class='tag'><a href='remove_tags.php?edit=$tag_id' id='link1'><p class='tag_content'><span>". $row['content']. "</span></P></a></div>"; 
                            }
                        } else{
                            echo "<div class='tag_list'><p>No Tags Found!</p></div>";
                        }
                    ?>
            </div>
        </div>
    </div>

    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>
</html>