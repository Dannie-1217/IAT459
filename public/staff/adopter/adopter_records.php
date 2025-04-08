<?php require_once("../../../private/functions/initialization.php") ?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/adoption_requests.css',
        PUBLIC_PATH . '/css/sidebar.css',
        PUBLIC_PATH . '/css/font.css',
        PUBLIC_PATH . '/css/grid.css',
        PUBLIC_PATH . '/css/footer.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
    ];

    require_once(ROOT_PATH . SHARED_PATH . '/header.php');
    require_once(ROOT_PATH . PRIVATE_PATH.'/functions/functions.php');

    if(!isset($_SESSION['user_name'])){
        header("Location: public/staff/login.php");
        exit();
    }

    $user_name = $_SESSION['user_name'];
    $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['user_id'];

    $adoptionRecordQuery = "SELECT adoption_records.pet_id, pet.pet_name, pet.pet_type, pet.location, adoption_records.status,adoption_records.adoption_date, pet_images.images
                            FROM adoption_records 
                            JOIN pet ON adoption_records.pet_id = pet.pet_id
                            LEFT JOIN pet_images ON adoption_records.pet_id = pet_images.pet_Id
                            WHERE user_id = '$user_id'
                            GROUP BY adoption_records.pet_id
                            ORDER BY adoption_records.adoption_date DESC";

    $allPetsResult = mysqli_query($connection, $adoptionRecordQuery);
?>

<body>
<div class="dashboard-wrapper">

    <!-- Sidebar -->
    <div class="sidebar-nav">
        <a href="adopter_dashboard.php" class="nav-btn">Dashboard</a>
        <a href="../../pages/homepage.php#trending" class="nav-btn">Adopt New Pet</a>
        <a href="favorite_pets.php" class="nav-btn">Favorite Pets</a>
        <a href="adopter_records.php" class="nav-btn">Check Records</a>
        <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
        <a href="../general/logout.php" class="nav-btn logout">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="dashboard-container">
        <h2 class="section-title">My Applications</h2>

        <div class="requests-grid">
            <?php if (mysqli_num_rows($allPetsResult) > 0): ?>
                <?php while ($pet = mysqli_fetch_assoc($allPetsResult)): 
                    $pet_id = $pet['pet_id']; ?>
                    <div class="request-card">
                        <div class="request-image">
                            <?php if (!empty($pet['images'])): ?>
                                <img src="<?php echo htmlspecialchars(PUBLIC_PATH . '/images/petimages/' . $pet['images']); ?>" alt="<?php echo htmlspecialchars($pet['pet_name']); ?>">
                            <?php else: ?>
                                <div class="placeholder-img"><i class="fas fa-paw"></i></div>
                            <?php endif; ?>
                        </div>

                        <div class="request-content">
                            <div class="request-details">
                                <h3><?php echo htmlspecialchars($pet['pet_name']); ?></h3>
                                <p><strong>Apply Date:</strong> <?php echo date('F j, Y', strtotime($pet['adoption_date'])) ?></p>
                                <p><strong>From:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
                                <?php
                                    $status = ucfirst(htmlspecialchars($pet['status']));
                                    $status_class = '';

                                    if ($status === 'Approved') {
                                        $status_class = 'status-approved';
                                    } elseif ($status === 'Declined') {
                                        $status_class = 'status-declined';
                                    } elseif ($status === 'Processing') {
                                        $status_class = 'status-processing';
                                    }
                                ?>
                                <p><strong>Status:</strong> <span class="<?php echo $status_class ?>"><?php echo $status ?></span></p>
                            </div>
                            <a href="record_details.php?edit=<?php echo $pet['pet_id']?>" class="view-btn">View Application</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-pets-msg">No pets posted yet.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>

</body>
</html>
