<?php
// Database connection
require_once("../../../private/functions/initialization.php");

// Get pet_id (hardcoded for this example)
$pet_id = 10070;

// Fetch images for the pet
$query = "SELECT images FROM pet_images WHERE pet_id = '$pet_id'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Pet Images</title>
</head>
<body>
    <h1>Pet Images for Pet ID: <?php echo $pet_id; ?></h1>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div style="margin-bottom: 20px;">
            <img src="<?php echo '../../images/petimages/' . $row['images']; ?>" alt="Pet Image" style="max-width: 300px;">
        </div>
    <?php endwhile; ?>

    <?php mysqli_free_result($result); ?>
</body>
</html>



//
<body>
<div class="dashboard-wrapper">
    <!-- Sidebar Navigation -->
    <div class="sidebar-nav">
        <a href="post_pet.php" class="nav-btn">Add New Pet</a>
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

            