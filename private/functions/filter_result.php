<?php

ob_clean();
require_once("initialization.php");

if(isset($_GET['pet_type'])) $pet_type=trim($_GET['pet_type']); 
if(isset($_GET['location'])) $location=trim($_GET['location']);
if(isset($_GET['page'])) $page=(int)$_GET['page'];

// validate page number
if($page < 1){
    $page = 1;
}

// Item per page
$itemPerPage = 9;
$offset = ($page-1) * $itemPerPage;


if(!empty($pet_type) && empty($location)){
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet.pet_type = '".$pet_type."'
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC
                    LIMIT $itemPerPage OFFSET $offset;";

    $count_query = "SELECT COUNT(DISTINCT pet.pet_id) as total
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet.pet_type = '".mysqli_real_escape_string($connection, $pet_type)."'";
}
else if(empty($pet_type) && !empty($location)){
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet.location = '".$location."'
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC
                    LIMIT $itemPerPage OFFSET $offset;";

    $count_query = "SELECT COUNT(DISTINCT pet.pet_id) as total
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet.location = '".mysqli_real_escape_string($connection, $location)."'";
}
else if(!empty($pet_type) && !empty($location)){
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet_type = '".$pet_type."' AND pet.location = '".$location."'
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC
                    LIMIT $itemPerPage OFFSET $offset;";

    $count_query = "SELECT COUNT(DISTINCT pet.pet_id) as total
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    WHERE pet_type = '".mysqli_real_escape_string($connection, $pet_type)."' 
                    AND pet.location = '".mysqli_real_escape_string($connection, $location)."'";
}
else{
    $general_query = "SELECT pet.pet_id, pet.pet_name, pet.location, pet.post_date, MIN(pet_images.images) AS pet_imgs
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id 
                    GROUP BY pet.pet_id
                    ORDER BY pet.post_date DESC
                    LIMIT $itemPerPage OFFSET $offset;";

    $count_query = "SELECT COUNT(DISTINCT pet.pet_id) as total
                    FROM pet 
                    JOIN pet_images ON pet.pet_id = pet_images.pet_id";
}

// echo $general_query;

$select_result = mysqli_query($connection, $general_query);

if(!$select_result){
    echo"query failed!";
    exit;
}



$count_result = mysqli_query($connection, $count_query);
$total_row = mysqli_fetch_assoc($count_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $itemPerPage);

echo '<input type="hidden" id="total_pages" value="'.$total_pages.'">';


if(mysqli_num_rows($select_result) != 0){
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
    echo "</div>";

    // Add pagination controls
    echo "<div class='pagination_controls'>
            <button id='prev_page' class='pagination_btn' " . ($page<=1 ? "disabled" : "") . "><</button>
            <span>Page $page of $total_pages</span>
            <button id='next_page' class='pagination_btn' " . ($page >= $total_pages ? "disabled" : "") . ">></button>
        </div>";
}else{
    echo"<p>No pets found matching your filters.</p>";
}
?>