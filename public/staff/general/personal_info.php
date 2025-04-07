<?php require_once("../../../private/functions/initialization.php") ?>

<?php

    if(!isset($_SESSION['user_name'])){
        header("Location: login.php");
        exit();
    }

    $user_name = $_SESSION['user_name'];

    // Fetch user details
    $userQuery = "SELECT * FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection ,$userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_type = $userData['user_type'];

    // Handle form submission for updates
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $new_user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
        $legal_name = mysqli_real_escape_string($connection, $_POST['legal_name']);
        $other_contact = mysqli_real_escape_string($connection, $_POST['other_contact']);

        // Check if username is unique
        if ($new_user_name !== $user_name){
            $checkUsernameQuery = "SELECT user_id 
                                FROM user 
                                WHERE user_name = '$new_user_name'";
            $checkResult = mysqli_query($connection, $checkUsernameQuery);
            if (mysqli_num_rows($checkResult)>0){
                array_push($errors, "Username already exists. Please choose another. ");
            } else{
                $user_name = $new_user_name; 
            }
        }

        if(empty($errors)){
            $updateQuery = "UPDATE user 
                            SET user_name='$new_user_name', legal_name = '$legal_name', other_contact = '$other_contact'
                            WHERE user_id='{$userData['user_id']}'";
            if(mysqli_query($connection, $updateQuery)){
                //$_SESSION['user_name'] = $new_user_name;
                $successMessage = "Profile updated successfully!";

                // Refresh user data
                $userQuery2 = "SELECT * FROM user WHERE user_name = '$user_name'";
                $userResult = mysqli_query($connection, $userQuery2);
                $userData = mysqli_fetch_assoc($userResult);
                $_SESSION['user_name'] = $userData['user_name'];
                //header("Location: ../../pages/homepage.php");
            } else{
                array_push($errors, "Failed to update profile: ". mysqli_error($connection));
            }
        }
    }
?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/personal_info.css',
        PUBLIC_PATH . '/css/sidebar.css',
        PUBLIC_PATH . '/css/font.css',
        PUBLIC_PATH . '/css/grid.css',
        PUBLIC_PATH . '/css/footer.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
    ];

    require_once(ROOT_PATH . SHARED_PATH . '/header.php');

    require_once(ROOT_PATH . PRIVATE_PATH.'/functions/functions.php');  
?>

<div class="dashboard-wrapper">
    <!-- Sidebar Navigation -->
    <div class="sidebar-nav">
        <?php
            if($user_type == 'adopter'){
                echo '
                <a href="../adopter/adopter_dashboard.php" class="nav-btn">Dashboard</a>
                <a href="../../pages/homepage.php" class="nav-btn">Adopt New Pet</a>
                <a href="../adopter/favorite_pets.php" class="nav-btn">Favorite Pets</a>
                <a href="personal_info.php" class="nav-btn">Update Info</a>
                <a href="logout.php" class="nav-btn logout">Logout</a>
                ';
            }
            else{
                echo'
                <a href="../provider/provider_dashboard.php" class="nav-btn">Dashboard</a>
                <a href="../provider/post_pet.php" class="nav-btn">Add New Pet</a>
                <a href="../provider/provider_dashboard_post.php" class="nav-btn">Pets Posted</a>
                <a href="../provider/adoption_requests.php" class="nav-btn">Adoption Requests</a>
                <a href="personal_info.php" class="nav-btn">Update Info</a>
                <a href="logout.php" class="nav-btn logout">Logout</a>
                ';
            }
        ?>
    </div>

    <!-- Main Content Area -->
    <div class="profile-container">
    <h2>Profile Update</h2>

        <?php if (isset($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>
        <?php
            if (!empty($errors)) {
                foreach ($errors as $err) {
                echo "<p style='color:red;'>$err</p>";
                }
            }
        ?>
        <!-- <div class="img-container">
            <img src="<?php echo htmlspecialchars(PUBLIC_PATH .'/images/profilephoto/' .$userData['profile_photo']); ?>" alt="Profile Photo" class="profile-photo">
        </div> -->

        <form method="POST" action="personal_info.php">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="user_name" value="<?php echo htmlspecialchars($userData['user_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="legal_name" value="<?php echo htmlspecialchars($userData['legal_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" value="<?php echo htmlspecialchars($userData['email']); ?>" disabled>
            </div>

            <div class="form-group">
                <label>User Type:</label>
                <input type="text" value="<?php echo htmlspecialchars($userData['user_type']); ?>" disabled>
            </div>

            <div class="form-group">
                <label>Other Contact:</label>
                <input type="text" name="other_contact" value="<?php echo htmlspecialchars($userData['other_contact']); ?>">
            </div>

            <div class="button-row">
                <input type="submit" value="Update Profile" class="submit-btn">
                <a href="change_password.php" class="reset-btn">Reset Password</a>
            </div>
        </form>
        <br>
        
    </div>

</div>

<?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>


</html>