<?php
require_once("../../../private/functions/initialization.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: public/staff/login.php");
    exit();
}

$user_name = $_SESSION['user_name'];

// Fetch user details
$userQuery = "SELECT * FROM user WHERE user_name = '$user_name'";
$userResult = mysqli_query($connection, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

// Handle form submission for password change
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Check if old password, new password, and confirm password are set
    if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
        // Check if old password is correct
        if (password_verify($_POST['old_password'], $userData['password'])) {
            // Validate that new password and confirm password are the same
            if ($_POST['new_password'] === $_POST['confirm_new_password']) {
                // Hash the new password
                $hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                // Update the password in the database
                $updatePasswordQuery = "UPDATE user SET password = '$hashedPassword' WHERE user_id = '{$userData['user_id']}'";
                if (mysqli_query($connection, $updatePasswordQuery)) {
                    $successMessage = "Password updated successfully!";
                } else {
                    array_push($errors, "Failed to update password: " . mysqli_error($connection));
                }
            } else {
                array_push($errors, "New passwords do not match.");
            }
        } else {
            array_push($errors, "Old password is incorrect.");
        }
    } else {
        array_push($errors, "All password fields are required.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container { width: 50%; margin: auto;text-align: center;  }
        .form-group { margin: 10px 0; }
        label { display: block; font-weight: bold; }
        input { width: 100%; padding: 8px; }
        .submit-btn { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<?php require(ROOT_PATH . SHARED_PATH.'/header.php'); ?>
<body>
    <div class="form-container">
        <h2>Change Password</h2>

        <?php if (isset($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>
        <?php
            if (!empty($errors)) {
                foreach ($errors as $err) {
                    echo "<p class='error'>$err</p>";
                }
            }
        ?>
        
        <form method="POST">
            <!-- Old Password -->
            <div class="form-group">
                <label>Old Password:</label>
                <input type="password" name="old_password" required>
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="new_password" required>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group">
                <label>Confirm New Password:</label>
                <input type="password" name="confirm_new_password" required>
            </div>

            <input type="submit" value="Change Password" class="submit-btn">
        </form>
        <a href="personal_info.php">Go Back to Perosnal Information</a>
    </div>
</body>
</html>


