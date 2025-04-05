<?php

ob_clean();
require_once("initialization.php");

if( isset($_GET['pet_type'])) $pet_type=trim($_GET['pet_type']); 
if( isset($_GET['location'])) $location=trim($_GET['location']);


if(!empty($pet_type) && empty($location)){
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet.pet_type = '".$pet_type."'
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC;";
}
else if(empty($pet_type) && !empty($location)){
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet.location = '".$location."'
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC;";
}
else if(!empty($pet_type) && !empty($location)){
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet_type = '".$pet_type."' AND pet.location = '".$location."'
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC;";
}
else{
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC;";
}

// echo $general_query;

$select_result = mysqli_query($connection, $general_query);

if(!$select_result){
    echo"query failed!";
    exit;
}

if(mysqli_num_rows($select_result) != 0){
    // echo"<table class='resultTable'><tr>";          
    //     echo "<td class='tableGrid'><p class='tableHeader'>Pet date</p></td>";  
    //     echo "<td class='tableGrid'><p class='tableHeader'>Pet Name</p></td>";     
    //     echo "<td class='tableGrid'><p class='tableHeader'>Location</p></td>";
    //     echo "<td class='tableGrid'><p class='tableHeader'>Image</p></td>";
    // echo "</tr><tr>";
    // while($row = mysqli_fetch_assoc($select_result)){
    //     $pet_id = $row['pet_id'];
    //     echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['post_date']. "</a></td>";  
    //     echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_name']. "</a></td>";
    //     echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['location']. "</a></td>";
    //     echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_imgs']. "</a></td>";
    //     echo"</tr>";
    // }
    // echo"</table>";
    echo "<div class='cardContainer grid card_grid'>";
    while($row = mysqli_fetch_assoc($select_result)){
        $pet_id = $row['pet_id'];
        $pet_name = htmlspecialchars($row['pet_name']);
        $location = htmlspecialchars($row['location']);
        $image = htmlspecialchars($row['pet_imgs']);

        echo "
            <div class='petCard'>
                <a href='pet_information.php?edit=$pet_id'>
                    <img src='../../public/images/petimages/$image' alt='$pet_name' class='petImage'>
                    <div class='petInfo'>
                        <h3 class='petName'>$pet_name</h3>
                        <p class='petLocation'>$location</p>
                    </div>
                </a>
            </div>
        ";
    }
}else{
    echo"<p>No pets found matching your filters.</p>";
}
?>