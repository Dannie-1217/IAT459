<?php require_once("../../../private/functions/initialization.php"); ?>

<?php
$page_styles = [
    PUBLIC_PATH . '/css/header.css',
    PUBLIC_PATH . '/css/request_processing.css',
    PUBLIC_PATH . '/css/sidebar.css',
    PUBLIC_PATH . '/css/font.css',
    PUBLIC_PATH . '/css/grid.css',
    PUBLIC_PATH . '/css/footer.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
];

require_once(ROOT_PATH . SHARED_PATH . '/header.php');
require_once(ROOT_PATH . PRIVATE_PATH . '/functions/functions.php');
?>

<?php
if (!isset($_SESSION['user_name'])) {
    header("Location: ../staff/general/login.php");
    exit();
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if (isset($_GET['decision'])) $decision = trim($_GET['decision']);

if (!empty($decision)) {
    if ($decision == 'Approved') {
        $update_query = "UPDATE adoption_records SET status = 'Approved' WHERE pet_id = $id";
        mysqli_query($connection, $update_query);
        $update_pet = "UPDATE pet SET status = 'Adopted' WHERE pet_id = $id";
        mysqli_query($connection, $update_pet);
        header("Location: request_processing.php?edit=$id");
        exit();
    } else if ($decision == 'Declined') {
        $update_query = "UPDATE adoption_records SET status = 'Declined' WHERE pet_id = $id";
        mysqli_query($connection, $update_query);
        $update_pet = "UPDATE pet SET status = 'Available' WHERE pet_id = $id";
        mysqli_query($connection, $update_pet);
        header("Location: request_processing.php?edit=$id");
        exit();
    } else {
        header("Location: request_processing.php?edit=$id");
        exit();
    }
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
}
$_SESSION['id'] = $id;

$user_name = $_SESSION['user_name'];
$userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
$userResult = mysqli_query($connection, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$user_id = $userData['user_id'];

$RequestQuery = "SELECT ar.pet_id, ar.adopted_before, ar.other_pets, ar.suitable_living_space, ar.reason_for_adoption, ar.status, MIN(pet_images.images) AS image, pet.pet_name, user.user_name 
                FROM adoption_records ar
                JOIN pet ON ar.pet_id = pet.pet_id
                JOIN user ON ar.user_id = user.user_id
                LEFT JOIN pet_images ON pet.pet_id = pet_images.pet_id
                WHERE ar.pet_id = $id";
$RequestResult = mysqli_query($connection, $RequestQuery);
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
            <?php if (!$RequestResult): ?>
                <p class="error-msg">Query failed!</p>
            <?php elseif (mysqli_num_rows($RequestResult) == 0): ?>
                <p>No adoption request found.</p>
            <?php else: ?>
                <?php while ($row = mysqli_fetch_assoc($RequestResult)): ?>
                    <div class="request-card">
                        <div class="request-header">
                            <img src="<?php echo PUBLIC_PATH . '/images/petimages/' . htmlspecialchars($row['image']) ?>" alt="Pet Image" class="pet-image">
                            <div class="pet-info">
                                <h2><?php echo htmlspecialchars($row['pet_name']) ?></h2>
                                <p><strong>Applicant:</strong> <?php echo ucfirst(htmlspecialchars($row['user_name'])) ?></p>
                                <p><strong>Status:</strong>
                                <span class="status <?php echo strtolower($row['status']) ?>">
                                    <?php echo ucfirst(htmlspecialchars($row['status'])) ?>
                                </span>
                                </p>
                            </div>
                        </div>

                        <div class="request-details">
                            <p><strong>Adopted Before:</strong> <?php echo htmlspecialchars($row['adopted_before']) ?></p>
                            <p><strong>Other Pets:</strong> <?php echo htmlspecialchars($row['other_pets']) ?></p>
                            <p><strong>Suitable Living Space:</strong> <?php echo htmlspecialchars($row['suitable_living_space']) ?></p>
                            <p><strong>Reason for Adoption:</strong> <?php echo htmlspecialchars($row['reason_for_adoption']) ?></p>
                        </div>

                        <form class="decision-form" method="GET"  action="request_processing.php">
                            <h3>Your Decision:</h3>
                            <label><input type="radio" name="decision" value="Later" checked> Later</label><br>
                            <label><input type="radio" name="decision" value="Approved" required> Approved</label><br>
                            <label><input type="radio" name="decision" value="Declined" required> Declined</label><br><br>
                            <input type="submit" value="Make Decision" class="btn-decision">
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>

</html>
