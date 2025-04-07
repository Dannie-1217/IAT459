<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/register.css',
        PUBLIC_PATH . '/css/font.css',
        PUBLIC_PATH . '/css/grid.css',
        PUBLIC_PATH . '/css/footer.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
    ];

    require_once(ROOT_PATH . SHARED_PATH . '/header.php');

    require_once(ROOT_PATH . PRIVATE_PATH.'/functions/functions.php');  
?>

<?php
    $user_name = $legal_name = $email = $other_contact = '';
    $user_type = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $legal_name = mysqli_real_escape_string($connection, $_POST['legal_name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $other_contact = mysqli_real_escape_string($connection, $_POST['other_contact']);
        $user_type = mysqli_real_escape_string($connection, $_POST['user_type']);


    // Password match check
    if ($password !== $confirm_password) {
        array_push($errors, 'Passwords do not match');
    } else {
        // Handle file upload
        $target_dir = PUBLIC_PATH . "/images/profilephoto/";

        if (!is_dir($target_dir)) {
            array_push($errors, "The image folder does not exist");
        } else {
            $upload = true;
            $file_name = basename($_FILES["profile_photo"]["name"]);
            $target_file = $target_dir . $user_name. "_" . $file_name;
            $new_file_name = $user_name . "_" . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate file upload
            if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["tmp_name"] != '') {
                $checkImg = getimagesize($_FILES["profile_photo"]["tmp_name"]);
                if ($checkImg === false) {
                    array_push($errors, "File is not a valid image.");
                    $upload = false;
                }
            } else {
                array_push($errors, "No file uploaded or file upload error.");
                $upload = false;
            }

            // Only allow certain file formats
            $allowed_types = ['jpg', 'jpeg', 'png','webp'];
            if (!in_array($imageFileType, $allowed_types)) {
                array_push($errors, "Only JPG, JPEG, PNG & WEBP files are allowed.");
                $upload = false;
            }

            if ($upload) {
                if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                    // Check if username or email already exists
                    $checkQuery = "SELECT * FROM user WHERE user_name = '$user_name' OR email = '$email'";
                    $result = mysqli_query($connection, $checkQuery);

                    if (mysqli_num_rows($result) > 0) {
                        array_push($errors, "Username or Email already exists");
                    } else {
                        $insertQuery = "INSERT INTO user (user_name, password, legal_name, email, other_contact, profile_photo, user_type)
                                        VALUES ('$user_name', '$password_hashed', '$legal_name', '$email', '$other_contact', '$new_file_name', '$user_type')";
                                if (mysqli_query($connection, $insertQuery)) {
                            $_SESSION['user_name'] = $user_name;
                            header("Location: welcome.php");
                            exit();
                        } else {
                            array_push($errors, "Database error: " . mysqli_error($connection));
                        }
                    }
                } else {
                    array_push($errors, "Sorry, there was an error uploading your file.");
                }
            }
        }
    }
}
?>


<body>

    <div class="registration-container">
        <h2 class="registration-title">Create Your Account</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $err): ?>
                    <p><?php echo $err; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="registration-form" action="register.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Profile Photo:</label>
                <div class="profile-photo-section">
                    <label class="custom-file-upload">
                        Choose File
                        <input type="file" name="profile_photo" accept="image/*" style="display: none;" required>
                    </label>
                    <img id="profile-preview" src="#" alt="Profile preview">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="user_name">Username:</label>
                <input class="form-input" type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($user_name); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password:</label>
                <input class="form-input" type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="confirm_password">Confirm Password:</label>
                <input class="form-input" type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="legal_name">Legal Name:</label>
                <input class="form-input" type="text" name="legal_name" id="legal_name" value="<?php echo htmlspecialchars($legal_name); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email:</label>
                <input class="form-input" type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="other_contact">Phone Number:</label>
                <input class="form-input" type="text" name="other_contact" id="other_contact" value="<?php echo htmlspecialchars($other_contact); ?>">
            </div>

           


            <div class="form-group">
                <label class="form-label">Account Type:</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="user_type" id="provider" value="provider" <?php echo ($user_type === 'provider') ? 'checked' : ''; ?> required>
                        <label for="provider">Pet Provider</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="user_type" id="adopter" value="adopter" <?php echo ($user_type === 'adopter') ? 'checked' : ''; ?> required>
                        <label for="adopter">Pet Adopter</label>
                    </div>
                </div>
            </div>

            <input class="submit-btn" type="submit" value="Register">
        </form>
    </div>

    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../js/photo_preview.js"></script>

</html>
