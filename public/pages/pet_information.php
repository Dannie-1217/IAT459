<?php require_once("../../private/functions/initialization.php") ?>

<?php
//Set CSS file.
echo '<style>'; 
include PUBLIC_PATH."/css/Formstyle.css"; 
echo '</style>';

require(SHARED_PATH.'/header.php');
echo "<h1>Pet Information: </h1>";

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
}  

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

require(SHARED_PATH.'/footer.php');
?>