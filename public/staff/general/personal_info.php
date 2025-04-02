<?php require_once("../../../private/functions/initialization.php") ?>

<?php

    if(!isset($_SESSION['user_name'])){
        header("Location: public/staff/login.php");
        exit();
    }

    $user_name = $_SESSION['user_name'];

    // Fetch user id based on username
    // $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    // $userResult = mysqli_query($connection, $userQuery);
    // $userData = mysqli_fetch_assoc($userResult);
    // $user_id = $userData['user_id'];

    // Fetch user details
    $userQuery = "SELECT * FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection ,$userQuery);
    $userData = mysqli_fetch_assoc($userResult);

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
                $_SESSION['user_name'] = $new_user_name;
                $successMessage = "Profile updated successfully!";

                // Refresh user data
                $userResult = mysqli_query($connection, $userQuery);
                $userData = mysqli_fetch_assoc($userResult);
            } else{
                array_push($errors, "Failed to update profile: ". mysqli_error($connection));
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body { font-family: Arial, sans-serif;  }
        .profile-container { width: 50%; margin: auto;text-align: center; }
        .profile-photo { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; }
        .form-group { margin: 10px 0; }
        label { display: block; font-weight: bold; }
        input { width: 100%; padding: 8px; }
        input[disabled] { background-color: #eee; }
        .submit-btn { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
        .black_button{width: 50%; margin: auto}
        .reset-btn {
            width: 100%; 
            padding: 5px 10px;
            background-color: #095F98; 
            color: white; 
            border: none; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block;
            text-align: center; 
            margin-bottom: 0.5rem
        }
        <?php include ROOT_PATH . PUBLIC_PATH."/css/Formstyle.css"; ?>
    </style>
   
</head>

<?php require(ROOT_PATH . SHARED_PATH.'/header.php'); ?>

<body>
    
    <div class="profile-container">
    <h2>User Profile</h2>

        <?php if (isset($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>
        <?php
            if (!empty($errors)) {
                foreach ($errors as $err) {
                echo "<p style='color:red;'>$err</p>";
                }
            }
        ?>
 
        <img src="<?php echo htmlspecialchars(PUBLIC_PATH .'/images/profilephoto/' .$userData['profile_photo']); ?>" alt="Profile Photo" class="profile-photo">

        <form method="POST">
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

            <input type="submit" value="Update Profile" class="submit-btn">
        </form>
        <br>
        <div class="black_button">
            <a href="change_password.php" class="reset-btn">Reset Password</a>
            <br>
            <a href="provider_dashboard.php" class="reset-btn">Back to Dashboard</a>
        </div>
    </div>
   
</body>

</html>