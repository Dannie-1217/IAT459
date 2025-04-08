<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/provider_dashboard_post.css',
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
    $recentPetsQuery = "SELECT pet.pet_name, pet.post_date, pet.pet_id, pet_images.images
                        FROM favorites 
                        JOIN pet ON favorites.pet_id = pet.pet_id 
                        LEFT JOIN pet_images ON pet.pet_id = pet_images.pet_Id
                        WHERE favorites.user_id = '$user_id' 
                        GROUP BY pet.pet_id
                        ORDER BY pet.post_date DESC";
    $allPetsResult = mysqli_query($connection, $recentPetsQuery);
?>

<body>

<div class="dashboard-wrapper">
    <!-- Sidebar Navigation -->
    <div class="sidebar-nav">
            <a href="adopter_dashboard.php" class="nav-btn">Dashboard</a>
            <a href="../../pages/homepage.php#trending" class="nav-btn">Adopt New Pet</a>
            <a href="favorite_pets.php" class="nav-btn">Favorite Pets</a>
            <a href="adopter_records.php" class="nav-btn">Check Records</a>
            <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
            <a href="../general/logout.php" class="nav-btn logout">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="pet_container">
        <h1>My Favorites</h1>

        <?php if (mysqli_num_rows($allPetsResult) > 0): ?>
            <div class="pet-grid">
                <?php while ($pet = mysqli_fetch_assoc($allPetsResult)): ?>
                    
                    <a class="pet-card" href="../../pages/pet_information.php?edit=<?php echo $pet['pet_id']?>">

                    <div>
                        <h3><?php echo htmlspecialchars($pet['pet_name']); ?></h3>
                        <p>Posted on: <?php echo htmlspecialchars($pet['post_date']); ?></p><br>

                        <?php if (!empty($pet['images'])): ?>
                            <img src="<?php echo htmlspecialchars(PUBLIC_PATH . '/images/petimages/' . $pet['images']); ?>" 
                                alt="<?php echo htmlspecialchars($pet['pet_name']); ?>">
                            <?php else: ?>
                                <p><em>No image uploaded.</em></p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endwhile; ?>

        <?php else: ?>
            <p>No pets posted yet.</p>
        <?php endif; ?>
        
    </div>

</div>

</body>

</html>