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
        header("Location: ../staff/general/login.php");
        exit();
      }
      
      $user_name = $_SESSION['user_name'];

      // Fetch user id based on username
      $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
      $userResult = mysqli_query($connection, $userQuery);
      $userData = mysqli_fetch_assoc($userResult);
      $user_id = $userData['user_id'];

      // Get count of pets posted by the user
      $petCountQuery = "SELECT COUNT(*) AS pet_count FROM provide_records WHERE user_id = '$user_id'";
      $petCountResult = mysqli_query($connection, $petCountQuery);
      $petCount = mysqli_fetch_assoc($petCountResult)['pet_count'];

      // Get count of adoption requests for this provider
      $adoptionRequestCountQuery = "SELECT COUNT(*) AS adoption_request_count FROM adoption_records ar JOIN provide_records pr ON ar.pet_id = pr.pet_id WHERE pr.user_id = '$user_id' AND ar.status = 'Processing'";
      $adoptionRequestCountResult = mysqli_query($connection, $adoptionRequestCountQuery);
      $adoptionRequestCount = mysqli_fetch_assoc($adoptionRequestCountResult)['adoption_request_count'];

      // Get recent 3 pet posts by this provider
      $recentPetsQuery = "SELECT pet.pet_name, pet.post_date 
                    FROM provide_records 
                    JOIN pet ON provide_records.pet_id = pet.pet_id 
                    WHERE provide_records.user_id = '$user_id' 
                    ORDER BY pet.post_date DESC 
                    LIMIT 3";
      $recentPetsResult = mysqli_query($connection, $recentPetsQuery);
?>


<body>
<div class="dashboard-wrapper">
    <!-- Sidebar Navigation -->
    <div class="sidebar-nav">

        <a href="provider_dashboard.php" class="nav-btn">Dashboard</a>
        <a href="post_pet.php" class="nav-btn">Add New Pet</a>
        <a href="provider_dashboard_post.php" class="nav-btn">Pets Posted</a>
        <a href="adoption_requests.php" class="nav-btn">Adoption Requests</a>
        <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
        <a href="../general/logout.php" class="nav-btn logout">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="dashboard-container">
        <h1>Welcome, <?= htmlspecialchars($user_name) ?></h1>

        <!-- Stats Section -->
        <div class="stats-row">
            <a href="provider_dashboard_post.php" class="stat-card">
                <h5>Pets Posted</h5>
                <p class="fs-2"><?= $petCount ?></p>
            </a>
            <a href="adoption_requests.php" class="stat-card bg-success">
                <h5>Adoption Requests</h5>
                <p class="fs-2"><?= $adoptionRequestCount ?></p>
            </a>
        </div>

        <!-- Recent Activity Section -->
        <div class="card-recent">
            <div class="card-recent-header">Recent Pet Posts</div>
            <ul class="recent-list">
                <?php while ($pet = mysqli_fetch_assoc($recentPetsResult)) : ?>
                    <li><?= htmlspecialchars($pet['pet_name']) ?> - Posted on <?= htmlspecialchars($pet['post_date']) ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

</div>

<?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>


</html>