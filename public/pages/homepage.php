<?php require_once("../../private/functions/initialization.php") ?>

<?php
    $page_styles = [
        PUBLIC_PATH . '/css/header.css',
        PUBLIC_PATH . '/css/homepage.css',
        PUBLIC_PATH . '/css/font.css',
        PUBLIC_PATH . '/css/grid.css',
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
                <a href="" class="button">Get Started</a>
            </div>
        </div>
        <div>
            <img src="../images/assets/welcome.png" width="1187" height="857" alt="dog and cat">
        </div>
    </div>

    <section>
        <h2>Trending Pets</h2>
        <!-- <h3>Filter</h3> -->
        <form id="searchForm">
            <?php
                drop_list('Pet Type: ', 'pet_type' , ['','dog','cat','horse','rabbit','bird','fish','other'],['','Dog','Cat','Horse','Rabbit','Bird','Fish','Other']);
                drop_list('Location: ', 'location' , ['','Burnaby','Surrey','Richmond','Vancouver','Delta','Langley','Coquitlam','North Vancouver','New Westminster'],['','Burnaby','Surrey','Richmond','Vancouver','Delta','Langley','Coquitlam','North Vancouver','New Westminster']);
            ?>
            <input type="submit" value="Search" class="search_btn">
        </form>
        <div id="search_res"></div>
    </section>


</main>



<?php

// if( isset($_GET['pet_type'])) $pet_type=trim($_GET['pet_type']); 
// if( isset($_GET['location'])) $location=trim($_GET['location']);


// if(!empty($pet_type) && empty($location)){
//     $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
//                     FROM pet 
//                     JOIN pet_images ON pet.pet_id = pet_images.pet_id 
//                     WHERE pet.pet_type = '".$pet_type."'
//                     GROUP BY pet.post_date DESC;";
// }
// else if(empty($pet_type) && !empty($location)){
//     $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
//                     FROM pet 
//                     JOIN pet_images ON pet.pet_id = pet_images.pet_id 
//                     WHERE pet.location = '".$location."'
//                     GROUP BY pet.post_date DESC;";
// }
// else if(!empty($pet_type) && !empty($location)){
//     $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
//                     FROM pet 
//                     JOIN pet_images ON pet.pet_id = pet_images.pet_id 
//                     WHERE pet_type = '".$pet_type."' AND pet.location = '".$location."'
//                     GROUP BY pet.post_date DESC;";

//     // $general_query = "SELECT pet_id, pet_name, pet_type, location 
//     // FROM pet WHERE pet_type = '".$pet_type."' AND location = '".$location."';";
// }
// else{
//     $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
//                     FROM pet 
//                     JOIN pet_images ON pet.pet_id = pet_images.pet_id 
//                     GROUP BY pet.post_date DESC;";
//     // $general_query = "SELECT pet_id, pet_name, pet_type, location FROM pet";
// }

// echo $general_query;

// $select_result = mysqli_query($connection, $general_query);

// if(!$select_result){
//     echo"query failed!";
//     exit;
// }

// if(mysqli_num_rows($select_result) != 0){
//     echo"<table class='resultTable'><tr>";          
//         echo "<td class='tableGrid'><p class='tableHeader'>Pet date</p></td>";  
//         echo "<td class='tableGrid'><p class='tableHeader'>Pet Name</p></td>";     
//         echo "<td class='tableGrid'><p class='tableHeader'>Location</p></td>";
//         echo "<td class='tableGrid'><p class='tableHeader'>Image</p></td>";
//     echo "</tr><tr>";
//     while($row = mysqli_fetch_assoc($select_result)){
//         $pet_id = $row['pet_id'];
//         echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['post_date']. "</a></td>";  
//         echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_name']. "</a></td>";
//         echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['location']. "</a></td>";
//         echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_imgs']. "</a></td>";
//         echo"</tr>";
//     }
//     echo"</table>";
// }
// //If result is empty, then show this warning.
// else{
//     echo"<tr>Result is empty!</tr>";
// }

// if (isset($_SESSION['user_name'])) {
//     $user_name = $_SESSION['user_name'];

//       // Fetch user id based on username
//     $userQuery = "SELECT user_id, user_type FROM user WHERE user_name = '$user_name'";
//     $userResult = mysqli_query($connection, $userQuery);
//     $userData = mysqli_fetch_assoc($userResult);
//     if($userData['user_type'] == 'adopter'){
//         $user_id = $userData['user_id'];

//         echo "<h1>Pets You May Like: </h1>";
//         $prefer_query = "SELECT pet.pet_id, pet.pet_name, pet.pet_type, pet.location FROM pet INNER JOIN pet_tags ON pet.pet_id = pet_tags.pet_id WHERE pet_tags.tag_id = ANY(SELECT tag_id FROM preferences WHERE user_id = '$user_id') GROUP BY pet.pet_id";
//         $prefer_result = mysqli_query($connection, $prefer_query);

//         if(!$prefer_result){
//             echo"query faled!";
//             exit;
//         }
        
//         if(mysqli_num_rows($prefer_result) != 0){
//             echo"<table class='resultTable'><tr>";          
//                 echo "<td class='tableGrid'><p class='tableHeader'>Pet ID</p></td>";  
//                 echo "<td class='tableGrid'><p class='tableHeader'>Pet Name</p></td>";   
//                 echo "<td class='tableGrid'><p class='tableHeader'>Pet Type</p></td>";  
//                 echo "<td class='tableGrid'><p class='tableHeader'>Location</p></td>";
//             echo "</tr><tr>";
//             while($row = mysqli_fetch_assoc($prefer_result)){
//                 $pet_id = $row['pet_id'];
//                 echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_id']. "</a></td>";  
//                 echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_name']. "</a></td>";
//                 echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_type']. "</a></td>"; 
//                 echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['location']. "</a></td>";
//                 echo"</tr>";
//             }
//             echo"</table>";
//         }

//         else{
//             echo"<tr>Result is empty!</tr>";
//         }
//     }
// }



// require_once(ROOT_PATH . SHARED_PATH.'/footer.php');
?>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../js/filter.js"></script>

</html>