<?php
require_once("../../private/functions/initialization.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

if (!isset($_SESSION)) session_start();

$user_name = $_SESSION['user_name'] ?? '';
$userType = $_SESSION['user_type'] ?? '';

if(isset($_SESSION['user_name'])){
    $user_name = $_SESSION['user_name'];
    $userQuery = "SELECT user_type FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $userType = $userData['user_type'];
}
if ($userType !== 'adopter') {
    echo "<p class='intro'>No recommendations for your user type.</p>";
    exit;
}

// Get user_id
$userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
$userResult = mysqli_query($connection, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$user_id = $userData['user_id'];

// Get total count for pagination
$count_query = "SELECT COUNT(DISTINCT pet.pet_id) AS total
                FROM pet
                JOIN pet_tags ON pet.pet_id = pet_tags.pet_id
                WHERE pet_tags.tag_id IN (SELECT tag_id FROM preferences WHERE user_id = '$user_id')
                AND pet.status = 'Available'";
$count_result = mysqli_query($connection, $count_query);
$total_row = mysqli_fetch_assoc($count_result);
$total_pages = ceil($total_row['total'] / $limit);

// Get paginated pets
$prefer_query = "SELECT pet.pet_id, pet.pet_name, pet.pet_type, pet.location, MIN(pet_images.images) AS image
                FROM pet
                JOIN pet_tags ON pet.pet_id = pet_tags.pet_id
                JOIN pet_images ON pet.pet_id = pet_images.pet_id
                WHERE pet_tags.tag_id IN (SELECT tag_id FROM preferences WHERE user_id = '$user_id')
                AND pet.status = 'Available'
                GROUP BY pet.pet_id
                LIMIT $limit OFFSET $offset";

$prefer_result = mysqli_query($connection, $prefer_query);


if(mysqli_num_rows($prefer_result) > 0): ?>
    <div class="cardContainer grid">
        <?php while($row = mysqli_fetch_assoc($prefer_result)): ?>
            <div class="petCard">
                <a href="pet_information.php?edit=<?php echo $row['pet_id']; ?>">
                    <img src="<?php echo PUBLIC_PATH . "/images/petimages/".htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pet_name']); ?>" class="petImage">
                    <div class="petInfo">
                        <h3 class="petName"><?php echo htmlspecialchars($row['pet_name']); ?></h3>
                        <p><strong>Type:</strong> <?php echo ucfirst(htmlspecialchars($row['pet_type'])); ?></p>
                        <p class="petLocation"><?php echo htmlspecialchars($row['location']); ?></p>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

    <input type="hidden" id="recommend_total_pages" value="<?php echo $total_pages; ?>">
<?php else: ?>
    <p class="intro">No recommendations found based on your preferences.</p>
<?php endif; ?>
