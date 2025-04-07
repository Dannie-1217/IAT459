<?php require_once("../../../private/functions/initialization.php") ?>

<?php

    if(!isset($_SESSION['user_name'])){
        header("Location: public/staff/login.php");
        exit();
    }


    $user_name = $_SESSION['user_name'];

    // Fetch user id based on username
    $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['user_id'];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $pet_name = mysqli_real_escape_string($connection, $_POST["pet_name"]);
        $location = mysqli_real_escape_string($connection, $_POST["location"]);
        $pet_type = mysqli_real_escape_string($connection, $_POST["pet_type"]);
        $description = mysqli_real_escape_string($connection, $_POST["description"]);
        $tags = isset($_POST['tags']) ? $_POST['tags']:[];
        $post_date = date("Y-m-d");
    
        mysqli_begin_transaction($connection);

        // Insert pet information into the "pet" table
        $insertPetQuery = "INSERT INTO pet (pet_name, location, pet_type, post_date, description, status)
                           VALUES ('$pet_name', '$location', '$pet_type', '$post_date', '$description', 'Available')";
    
        if (mysqli_query($connection, $insertPetQuery)) {
            $pet_id = mysqli_insert_id($connection); // Get the inserted pet ID

            $insertProviderQuery = "INSERT INTO provide_records (user_id, pet_id) VALUES ('$user_id', '$pet_id')";
            if (!mysqli_query($connection, $insertProviderQuery)) {
                array_push($errors, "Failed to record provider relationship: " . mysqli_error($connection));
            }
    
            // Save images inside the PUBLIC images folder
            $target_dir = ROOT_PATH . PUBLIC_PATH . "/images/petimages/";
            if (!is_dir($target_dir)) {
                array_push($errors, "The image folder does not exist");
            } else {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $original_name = basename($_FILES['images']['name'][$key]);
                    $imageFileType = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    
                    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
                    if (in_array($imageFileType, $allowed_types)) {
                        // Rename the file as pet_id + original name for uniqueness
                        $file_name = $pet_id . "_" . $original_name;
                        $target_file = $target_dir . $file_name;
    
                        if (move_uploaded_file($tmp_name, $target_file)) {
                            // ONLY store the file name (not the full path) in the database
                            $imgQuery = "INSERT INTO pet_images (pet_id, images) VALUES ('$pet_id', '$file_name')";
                            mysqli_query($connection, $imgQuery);
                        } else {
                            array_push($errors, "Failed to upload image: " . $original_name);
                        }
                    } else {
                        array_push($errors, "Invalid image format for: " . $original_name);
                    }
                }
            }

            // Process tags
            foreach ($tags as $tag_name){
                $tag_name = mysqli_real_escape_string($connection, $tag_name);
                $tagQuery = "SELECT tag_id FROM tags WHERE content = '$tag_name'";
                $tagResult = mysqli_query($connection, $tagQuery);

                if(mysqli_num_rows($tagResult)>0){
                    $tagRow = mysqli_fetch_assoc($tagResult);
                    $tag_id = $tagRow['tag_id'];
                } else{
                    if(!mysqli_query($connection, "INSERT INTO tags (content) VALUES ('$tag_name')")){
                        array_push($errors, "Failed to inset new tag: " . mysqli_error($connection));
                    } else{
                        $tag_id = mysqli_insert_id($connection);
                    }
                }

                if(!mysqli_query($connection, "INSERT INTO pet_tags(pet_id, tag_id) VALUES ('$pet_id', '$tag_id')")){
                    array_push($errors, "Failed to associate tag with pet: " . mysqli_error($connection));
                }
            }
    
            if (empty($errors)) {
                mysqli_commit($connection);
                echo "<p style='color:green;'>Pet Posted Successfully!</p>";
            } else {
                mysqli_rollback($connection);
                foreach ($errors as $err) {
                    echo "<p style='color:red;'>$err</p>";
                }
            }
        } else {
            echo "<p style='color:red;'>Failed to post pet: " . mysqli_error($connection) . "</p>";
        }
    }

?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/post_pet.css',
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
        <!-- Sidebar Navigation -->
        <div class="sidebar-nav">
            <a href="../provider/provider_dashboard.php" class="nav-btn">Dashboard</a>
            <a href="../provider/post_pet.php" class="nav-btn">Add New Pet</a>
            <a href="../provider/provider_dashboard_post.php" class="nav-btn">Pets Posted</a>
            <a href="../provider/adoption_requests.php" class="nav-btn">Adoption Requests</a>
            <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
            <a href="../general/logout.php" class="nav-btn logout">Logout</a>
        </div>

        <!-- Main Content Area -->
        <div class="add_post_container">
            <h1>Post a Pet</h1>

            <?php
                if (!empty($errors)) {
                    foreach ($errors as $err) {
                    echo "<p style='color:red;'>$err</p>";
                    }
                }
            ?>

            <form action="post_pet.php" method="POST" enctype="multipart/form-data">
                <label>Pet Name: </label><br>
                <input type = "text" name = "pet_name" required/><br><br>

                <label>Location: </label><br>
                <input type= "text" name = "location" required/><br><br>

                <label>Pet Type:</lable><br><br>
                <select name = "pet_type" required>
                    <option value = ""></option>
                    <option value = "dog">Dog</option>
                    <option value = "cat">Cat</option>
                    <option value="horse">Horse</option>
                    <option value="rabbit">Rabbit</option>
                    <option value="bird">Bird</option>
                    <option value="fish">Fish</option>
                    <option value="others">Others</option>
                </select><br><br>

                <label>Description: </label><br>
                <textarea name = "description" required></textarea><br><br>

                <label>Add Tags: </label><br>
                <input type="text" id="tag_input" placeholder="Type to search or add new...">
                <button type="button" onclick="addTagFromInput()">Add</button>

                <div id="tag_suggestions"></div>
                <div id="tag_list"></div>
                <div id="tags"></div><br><br>

                <label>Upload Pet Images: </label><br>
                <input type = "file" name = "images[]" multiple accept = "image/*"><br><br>

                <input type = "submit" value = "Post"/>

            </form>
        </div>
    </div>
    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../js/tag_handler.js"></script>
<script src="../../js/pet_img.js"></script>
</html>

