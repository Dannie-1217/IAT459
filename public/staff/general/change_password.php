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

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/change_password.css',
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
            <a href="personal_info.php" class="nav-btn">Update Info</a>
            <a href="logout.php" class="nav-btn logout">Logout</a>
        </div>

        <!-- Main Content Area -->
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
        </div>

    </div>

    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>
</html>


