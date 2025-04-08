<?php require_once("../../private/functions/initialization.php") ?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/homepage.css',
        PUBLIC_PATH . '/css/font.css',
        PUBLIC_PATH . '/css/grid.css',
        PUBLIC_PATH . '/css/footer.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
    ];

    require_once(ROOT_PATH . SHARED_PATH . '/header.php');

    require_once(ROOT_PATH . PRIVATE_PATH.'/functions/functions.php');  
?>


<main>
    <div class="grid welcome_grid welcome_container">
        <div class="welcome_left">
            <h1>Happy Pets,</h1>
            <p id="welcome_title">Happy Owners🐾</p>
            <p>🔍  With us, you can find pets more easily and quickly! </p>
            <div class="button_div">
                <a href="#trending" class="button">Get Started</a>
            </div>
        </div>
        <div>
            <img src="../images/assets/welcome.png" width="1187" height="857" alt="dog and cat">
        </div>
    </div>

    <section id="trending">
        <h2>Trending Pets</h2>
       
        <form id="searchForm">
    <?php
        drop_list('Pet Type:', 'pet_type', ['','dog','cat','horse','rabbit','bird','fish','other'], ['All','Dog','Cat','Horse','Rabbit','Bird','Fish','Other']);
        drop_list('Location:', 'location', ['','Burnaby','Surrey','Richmond','Vancouver','Delta','Langley','Coquitlam','North Vancouver','New Westminster'], ['All','Burnaby','Surrey','Richmond','Vancouver','Delta','Langley','Coquitlam','North Vancouver','New Westminster']);
    ?>
    <input type="submit" value="Search" class="search_btn">
</form>

        <div id="search_res"></div>
    </section>



    <?php
        // Fetch user id based on username
        if(isset($_SESSION['user_name'])){
            $userQuery = "SELECT user_id FROM user WHERE user_name = '$user_name'";
            $userResult = mysqli_query($connection, $userQuery);
            $userData = mysqli_fetch_assoc($userResult);
            $user_id = $userData['user_id'];
        }

        if (isset($userType) && $userType === 'adopter'){
            $prefer_query = "SELECT pet.pet_id, pet.pet_name, pet.pet_type, pet.location, MIN(pet_images.images) AS image
                            FROM pet
                            JOIN pet_tags ON pet.pet_id = pet_tags.pet_id
                            JOIN pet_images ON pet.pet_id = pet_images.pet_id
                            WHERE pet_tags.tag_id = ANY(SELECT tag_id 
                                                        FROM preferences 
                                                        WHERE user_id = '$user_id') AND pet.status = 'Available'
                            GROUP BY pet.pet_id
                            LIMIT 10";
            $prefer_result = mysqli_query($connection, $prefer_query);

            if(!$prefer_result){
                echo"query failed!";
                exit;
            }
        }
    ?>

    
    <?php if (isset($userType) && $userType === 'adopter') { ?>

    <section id="recommendations">
        <h2>Recommendations</h2>
        
        <?php if(mysqli_num_rows($prefer_result)>0): ?>
            <div class="cardContainer grid">
                <?php while($row = mysqli_fetch_assoc($prefer_result)): 
                    $pet_id = $row['pet_id'];
                    $pet_name = htmlspecialchars($row['pet_name']);
                    $pet_type = htmlspecialchars($row['pet_type']);
                    $location = htmlspecialchars($row['location']);
                    $image_path = htmlspecialchars($row['image']);
                ?>
                    <div class="petCard">
                        <a href="pet_information.php?edit=<?php echo $pet_id; ?>">
                            <img src="<?php echo PUBLIC_PATH . "/images/petimages/".$image_path; ?>" alt="<?php echo $pet_name; ?>" class="petImage">
                            <div class="petInfo">
                                <h3 class="petName"><?php echo $pet_name; ?></h3>
                                <p><strong>Type:</strong> <?php echo ucfirst($pet_type); ?></p>
                                <p class="petLocation"><?php echo $location; ?></p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="intro">No recommendations found based on your preferences.</p>
        <?php endif; ?> 



    </section>

    <?php }?>


</main>


</body>

<?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/filter.js"></script>

</html>