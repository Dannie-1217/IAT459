<?php require_once("../../../private/functions/initialization.php") ?>

<?php
$page_styles = [
    PUBLIC_PATH . '/css/header.css',
    PUBLIC_PATH . '/css/pet_information.css',
    PUBLIC_PATH . '/css/font.css',
    PUBLIC_PATH . '/css/grid.css',
    PUBLIC_PATH . '/css/footer.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
];

require_once(ROOT_PATH . SHARED_PATH . '/header.php');
require_once(ROOT_PATH . PRIVATE_PATH.'/functions/functions.php');  

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
} 

$_SESSION['pet_id'] = $id;

$user_type = 'adopter';
if(isset($_SESSION['user_name'])){
    $user_name = $_SESSION['user_name'];
    $userQuery = "SELECT user_type FROM user WHERE user_name = '$user_name'";
    $userResult = mysqli_query($connection, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $user_type = $userData['user_type'];
}

$general_query = "SELECT pet.pet_name, pet.pet_id, pet.pet_type, pet.location, adoption_records.adoption_date, adoption_records.status, adoption_records.adopted_before, adoption_records.other_pets, adoption_records.suitable_living_space, adoption_records.reason_for_adoption
                        FROM adoption_records 
                        JOIN pet ON adoption_records.pet_id = pet.pet_id
                        WHERE adoption_records.pet_id = '$id'";
$select_result = mysqli_query($connection, $general_query);

$image_query = "SELECT images FROM pet_images WHERE pet_id = $id";
$image_result = mysqli_query($connection, $image_query);

$images = [];

if ($image_result && mysqli_num_rows($image_result) > 0) {
    while ($img_row = mysqli_fetch_assoc($image_result)) {
        $images[] = htmlspecialchars($img_row['images']);
    }
}

if(!$select_result || !$image_result){
    echo"<div class='error'>Query failed!</div>";
    exit;
}

if(mysqli_num_rows($select_result) != 0):
    $pet = mysqli_fetch_assoc($select_result);
?>
    <main class="pet-profile-container">
        <div class="title-container">
            <a href="<?php echo PUBLIC_PATH . '/pages/homepage.php'; ?>" class="minimal-back-btn" aria-label="Go back to pets list">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1 class="pet-profile-title"><?php echo htmlspecialchars($pet['pet_name']); ?> Request</h1>
        </div>
        
        <div class="pet-card">
            <div class="image-gallery-container">
                <div class="main-image-container">
                    <img src="../../../public/images/petimages/<?php echo htmlspecialchars($images[0])?>"
                        alt="<?php echo $pet['pet_name'];?>"
                        class="main-image active"
                        data-index="0">

                    <button class="image-nav prev" aria-label="Previous image">&lt;</button>
                    <button class="image-nav next" aria-label="Next image">&gt;</button>
                </div>

                <div class="thumbnail-gallery">
                    <?php foreach ($images as $index => $img): ?>
                        <img src="../../../public/images/petimages/<?php echo htmlspecialchars($img); ?>" 
                            alt="Thumbnail <?php echo $index + 1; ?>" 
                            class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                            data-index="<?php echo $index; ?>">
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pet-details">
                <div class="pet-meta">
                    <span class="pet-type"><?php echo ucfirst($pet['pet_type']); ?></span>
                    <span class="pet-location"><i class="fas fa-map-marker-alt"></i> <?php echo $pet['location']; ?></span>
                </div>
                
                <div class="pet-info">
                    <h2><?php echo $pet['pet_name']; ?></h2>
                    <p class="pet-post-date">Apply Date: <?php echo date('F j, Y', strtotime($pet['adoption_date'])); ?></p>
                    
                    <div class="pet-description">
                        <h3>Application Questions</h3>
                        <p>Have you adopted a pet before: <span style="color: #1565c0;"><?php echo htmlspecialchars($pet['adopted_before']); ?></span></p>
                        <p>Do you have other pets at home: <span style="color: #1565c0;"><?php echo htmlspecialchars($pet['other_pets']); ?></p>
                        <p>Do you have a suitable living space for this pet: <span style="color: #1565c0;"><?php echo htmlspecialchars($pet['suitable_living_space']); ?></p>
                        <p>Why do you want to adopt this pet:</p>
                        <p style="color: #1565c0; "><?php echo htmlspecialchars($pet['reason_for_adoption']); ?></p>
                    </div>
                </div>
                
                <?php 
                $tag_query = "SELECT tags.content FROM tags LEFT JOIN pet_tags ON pet_tags.tag_id = tags.tag_id WHERE pet_tags.pet_id = ".$id;
                $tag_result = mysqli_query($connection, $tag_query);
                
                if(mysqli_num_rows($tag_result) > 0): ?>
                    <div class="pet-tags">
                        <h3>Request Status:</h3>
                        <p><?php echo nl2br(htmlspecialchars($pet['status'])); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php
                    if($user_type == 'adopter'){
                        echo '<div class="pet-actions">
                            <form action="adopter_dashboard.php" method="get" class="action-form">
                                <button type="submit" class="btn-apply">
                                    <i class="fas fa-paw"></i> Back to Dashboard!
                                </button>
                            </form>
                            </div>';
                    }
                ?>
            </div>
        </div>
    </main>
<?php else: ?>
    <div class="error">No pet found with this ID</div>
<?php endif; ?>

<?php require_once(ROOT_PATH . SHARED_PATH.'/footer.php'); ?>

<script src="../js/change_img.js"></script>
</body>
</html>