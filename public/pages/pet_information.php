<?php require_once("../../private/functions/initialization.php") ?>

<?php
//Set CSS file.
echo '<style>'; 
include ROOT_PATH . PUBLIC_PATH."/css/Formstyle.css"; 
echo '</style>';

require_once(ROOT_PATH . SHARED_PATH.'/header.php');
echo "<h1>Pet Information: </h1>";

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
} 

$_SESSION['pet_id'] = $id;

$general_query = "SELECT * FROM pet WHERE pet_id = ".$id;

$select_result = mysqli_query($connection, $general_query);

if(!$select_result){
    echo"query faled!";
    exit;
}

if(mysqli_num_rows($select_result) != 0){
    echo"<table class='resultTable'><tr>";          
        echo "<td class='tableGrid'><p class='tableHeader'>Pet ID</p></td>";  
        echo "<td class='tableGrid'><p class='tableHeader'>Pet Name</p></td>";   
        echo "<td class='tableGrid'><p class='tableHeader'>Pet Type</p></td>";  
        echo "<td class='tableGrid'><p class='tableHeader'>Location</p></td>";
        echo "<td class='tableGrid'><p class='tableHeader'>Description</p></td>";
        echo "<td class='tableGrid'><p class='tableHeader'>Post Date</p></td>";
    echo "</tr><tr>";
    while($row = mysqli_fetch_assoc($select_result)){
        $pet_id = $row['pet_id'];
        echo "<td class='tableGrid'>". $row['pet_id']. "</td>";  
        echo "<td class='tableGrid'>". $row['pet_name']. "</td>";
        echo "<td class='tableGrid'>". $row['pet_type']. "</td>"; 
        echo "<td class='tableGrid'>". $row['location']. "</td>";
        echo "<td class='tableGrid'>". $row['description']. "</td>";
        echo "<td class='tableGrid'>". $row['post_date']. "</td>";
        echo"</tr>";
    }
    echo"</table>";
}
//If result is empty, then show this warning.
else{
    echo"<tr>Result is empty!</tr>";
}

echo "Tags:";

$tag_query = "SELECT tags.content FROM tags LEFT JOIN pet_tags ON pet_tags.tag_id = tags.tag_id WHERE pet_tags.pet_id = ".$id;

$tag_result = mysqli_query($connection, $tag_query);

if(!$tag_result){
    echo"query faled!";
    exit;
}

if(mysqli_num_rows($tag_result) != 0){
    echo"<table class='resultTable'><tr>";          
        echo "<td class='tableGrid'><p class='tableHeader'>Tags</p></td>";  
    echo "</tr><tr>";
    while($row = mysqli_fetch_assoc($tag_result)){
        echo "<td class='tableGrid'>". $row['content']. "</td>";  
        echo"</tr>";
    }
    echo"</table>";
}
//If result is empty, then show this warning.
else{
    echo"<tr>Result is empty!</tr>";
}

echo '<form action="../../private/functions/add_favorite.php">
            <input type="submit" value="Add to Favorite List">
        </form>';

echo '<form action="apply_page.php">
        <input type="submit" value="Apply for Adoption">
      </form>';      

require_once(ROOT_PATH . SHARED_PATH.'/footer.php');
?>