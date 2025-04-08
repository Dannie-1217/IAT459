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
        header("Location: ../staff/general/login.php");
        exit();
    }

    $user_name = $_SESSION['user_name'];
    $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_id = $userData['user_id'];

    $adoptionRequestQuery = "SELECT pet.pet_id, pet.pet_name, user.user_name, ar.status, ar.adoption_date, MIN(pet_images.images) AS image
        FROM adoption_records ar
        JOIN provide_records pr ON ar.pet_id = pr.pet_id
        JOIN pet ON ar.pet_id = pet.pet_id
        JOIN user ON ar.user_id = user.user_id
        LEFT JOIN pet_images ON pet.pet_id = pet_images.pet_id
        WHERE pr.user_id = '$user_id'
        GROUP BY pet.pet_id, pet.pet_name, ar.status
        ORDER BY ar.adoption_date DESC";

    $adoptionRequestResult = mysqli_query($connection, $adoptionRequestQuery);

    if (!$adoptionRequestResult) {
        echo "Query failed!";
        exit;
    }
?>

<body>
<div class="dashboard-wrapper">

    <!-- Sidebar -->
    <div class="sidebar-nav">
        <a href="provider_dashboard.php" class="nav-btn">Dashboard</a>
        <a href="post_pet.php" class="nav-btn">Add New Pet</a>
        <a href="provider_dashboard_post.php" class="nav-btn">Pets Posted</a>
        <a href="adoption_requests.php" class="nav-btn active">Adoption Requests</a>
        <a href="../general/personal_info.php" class="nav-btn">Update Info</a>
        <a href="../general/logout.php" class="nav-btn logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h2 class="section-title">Adoption Requests</h2>

        <div class="requests-grid">
            <?php if (mysqli_num_rows($adoptionRequestResult) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($adoptionRequestResult)): ?>
                    <div class="request-card">
                        <div class="request-image">
                            <?php if ($row['image']): ?>
                                <img src="../../images/petimages/<?php echo htmlspecialchars($row['image']) ?>" alt="Pet Image">
                            <?php else: ?>
                                <div class="placeholder-img"><i class="fas fa-paw"></i></div>
                            <?php endif; ?>
                        </div>

                        <div class="request-content">
                            <div class="request-details">
                                <?php 
                                    $status = ucfirst(htmlspecialchars($row['status']));
                                    $status_class = '';
                                    if($status === "Processing"): 
                                ?>
                                    <h3><?= htmlspecialchars($row['pet_name']) ?><span> (Awaiting Processing...)</span></h3>
                                <?php else: ?>
                                    <h3><?= htmlspecialchars($row['pet_name']) ?></h3>
                                <?php endif; ?>
                                <?php
                                   

                                    if ($status === 'Approved') {
                                        $status_class = 'status-approved';
                                    } elseif ($status === 'Declined') {
                                        $status_class = 'status-declined';
                                    } elseif ($status === 'Processing') {
                                        $status_class = 'status-processing';
                                    }
                                ?>
                                <p><strong>Status:</strong> <span class="<?php echo $status_class ?>"><?php echo $status ?></span></p>
                                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($row['adoption_date'])) ?></p>
                            </div>
                            <a href="request_processing.php?edit=<?php echo $row['pet_id'] ?>" class="view-btn">View Request</a>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-requests-msg">You don't have any adoption requests.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>
</html>
