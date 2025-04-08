<?php require_once("../../private/functions/initialization.php") ?>

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

    if(!isset($_SESSION['user_name'])){
        header("Location: ../staff/general/login.php");
        exit();
    }

    elseif (isset($_SESSION['pet_id'])) {
        $id = $_SESSION['pet_id'];  // Get pet_id from session
    }
    
    $_SESSION['pet_id'] = $id;
  
    $user_name = $_SESSION['user_name'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $q1 = $_POST['q1'];
        $q2 = $_POST['q2'];
        $q3 = $_POST['q3'];
        $q4 = $_POST['q4'];
        if(!empty($q1) && !empty($q2) && !empty($q3) && !empty($q4)){
            if (isset($_SESSION['user_name'])) {
                $user_name = $_SESSION['user_name'];
                $user_query = "SELECT user_id FROM user WHERE user_name = '" . $user_name . "'";
                $user_res = mysqli_query($connection, $user_query);
                $user_id = mysqli_fetch_assoc($user_res)['user_id'];
                $pet_id = $_SESSION['pet_id'];

                date_default_timezone_set('America/Vancouver');
                $date = date('Y-m-d', time());

                $apply = "INSERT INTO adoption_records(user_id, pet_id, adopted_before, other_pets, suitable_living_space, reason_for_adoption, adoption_date, status) 
                    VALUES($user_id, $pet_id, '$q1', '$q2', '$q3', '$q4', '$date', 'Processing')";
                echo $apply;
                $add_res = mysqli_query($connection, $apply);

                if(!$add_res){
                    echo"query faled!";
                    exit;
                }
                else{
                    header("Location: ../staff/adopter/adopter_dashboard.php");
                }

            }
            else{
                header("Location: ../staff/general/login.php");
            }
        }
        else{
            echo "Please Answer ALL Application Questions!";
        }
    }

    require_once(ROOT_PATH . SHARED_PATH.'/header.php');
    
    $general_query = "SELECT * FROM pet WHERE pet_id = ".$id;
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
            $pet = mysqli_fetch_assoc($select_result);?>

    <main class="pet-profile-container">
        <div class="title-container">
            <a href="<?php echo PUBLIC_PATH . '/pages/homepage.php'; ?>" class="minimal-back-btn" aria-label="Go back to pets list">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1 class="pet-profile-title">Application Form:</h1>
        </div>
        
        <div class="pet-card">
            <div class="image-gallery-container">
                <div class="main-image-container">
                    <img src="../../public/images/petimages/<?php echo htmlspecialchars($images[0])?>"
                        alt="<?php echo $pet['pet_name'];?>"
                        class="main-image active"
                        data-index="0">

                    <button class="image-nav prev" aria-label="Previous image">&lt;</button>
                    <button class="image-nav next" aria-label="Next image">&gt;</button>
                </div>

                <div class="thumbnail-gallery">
                    <?php foreach ($images as $index => $img): ?>
                        <img src="../../public/images/petimages/<?php echo htmlspecialchars($img); ?>" 
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
                    <p class="pet-post-date">Posted on: <?php echo date('F j, Y', strtotime($pet['post_date'])); ?></p>
                    
                    <div class="pet-description">
                        <h3>Application Questions</h3>
                        <form action="apply_page.php" method="POST" enctype="multipart/form-data">
                            <label>Have you adopted a pet before?</label><br>
                            <select name="q1">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select> <br>
                       
                            <label>Do you have other pets right now?</label><br>
                            <select name="q2">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select> <br>
                        
                            <label>Do you have a suitable living space for this pet?</label><br>
                            <select name="q3">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select><br>
              
                            <label>Why do you want to adopt this pet?</label><br>
                            <textarea name="q4" rows="1" style='width:  16.76rem ; 
                                height: 4rem;
                                margin-right: 1em;
                                margin-top: 0.5em;
                                resize: none;'></textarea><br>

                            <button type="submit" class="btn-apply">
                                    <i class="fas fa-paw"></i> Apply for Adoption
                            </button>
                        </form>
                    </div>
                </div>
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