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
        header("Location: public/staff/login.php");
        exit();
    }

    $user_name = $_SESSION['user_name'];

    // Fetch user id based on username
    $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['user_id'];

    // Get all pet posts by this provider
    $allPetsQuery = "SELECT pet.pet_id, pet.pet_name, pet_images.images, pet.post_date
    FROM provide_records 
    JOIN pet ON provide_records.pet_id = pet.pet_id
    LEFT JOIN pet_images ON pet.pet_id = pet_images.pet_Id
    WHERE provide_records.user_id = '$user_id'
    GROUP BY pet.pet_id";
    $allPetsResult = mysqli_query($connection, $allPetsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Posted Pets</title>
</head>
<?php require(ROOT_PATH . SHARED_PATH.'/header.php'); ?>
<body>
    <h1>My Posted Pets</h1>

    <?php if (mysqli_num_rows($allPetsResult) > 0): ?>
        <?php while ($pet = mysqli_fetch_assoc($allPetsResult)): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
                <h3><?php echo htmlspecialchars($pet['pet_name']); ?></h3>
                <p>Posted on: <?php echo htmlspecialchars($pet['post_date']); ?></p>
                
                <?php if (!empty($pet['images'])): ?>
                    <img src="<?php echo htmlspecialchars(PUBLIC_PATH .'/images/petimages/' . $pet['images']); ?>" 
                         alt="<?php echo htmlspecialchars($pet['pet_name']); ?>" 
                         style="width: 200px; height: auto;">
                <?php else: ?>
                    <p><em>No image uploaded.</em></p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No pets posted yet.</p>
    <?php endif; ?>

</body>
</html>
