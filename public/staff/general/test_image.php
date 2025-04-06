<?php
// Database connection
require_once("../../../private/functions/initialization.php");

// Get pet_id (hardcoded for this example)
$pet_id = 10070;

// Fetch images for the pet
$query = "SELECT images FROM pet_images WHERE pet_id = '$pet_id'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Pet Images</title>
</head>
<body>
    <h1>Pet Images for Pet ID: <?php echo $pet_id; ?></h1>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div style="margin-bottom: 20px;">
            <img src="<?php echo '../../images/petimages/' . $row['images']; ?>" alt="Pet Image" style="max-width: 300px;">
        </div>
    <?php endwhile; ?>

    <?php mysqli_free_result($result); ?>
</body>
</html>


<div class="pet-images">
                <?php while ($img_row = mysqli_fetch_assoc($image_result)): 
                    $img = htmlspecialchars($img_row['images']); ?>
                    <img src="../../public/images/petimages/<?php echo $img; ?>" alt="<?php echo $pet['pet_name']; ?>" class="pet-image">
                <?php endwhile; ?>
            </div>
            