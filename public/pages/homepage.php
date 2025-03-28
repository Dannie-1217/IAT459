<?php require_once("../../private/functions/initialization.php") ?>

<?php
//Set CSS file.
echo '<style>'; 
include PUBLIC_PATH."/css/Formstyle.css"; 
echo '</style>';

if( isset($_GET['pet_type'])) $pet_type=trim($_GET['pet_type']); 
if( isset($_GET['location'])) $location=trim($_GET['location']);

require(SHARED_PATH.'/header.php');
require(PRIVATE_PATH.'/functions/functions.php');

echo "<form action= homepage.php>";
echo "<table>";
echo "<tr><td><lable>Filter </lable></td></tr>";
drop_list('Pet Type: ', 'pet_type' , ['','dog','cat','horse','rabbit','bird','fish','other'],['','Dog','Cat','Horse','Rabbit','Bird','Fish','Other']);
drop_list('Location: ', 'location' , ['','Burnaby','Surrey','Richmond','Vancouver','Delta','Langley','Coquitlam','North Vancouver','New Westminster'],['','Burnaby','Surrey','Richmond','Vancouver','Delta','Langley','Coquitlam','North Vancouver','New Westminster']);
search_button();
echo "</table>";
echo "</form>";

echo "<h1>Pet List: </h1>";

if(!empty($pet_type) && empty($location)){
    $general_query = "SELECT pet_id, pet_name, pet_type, location FROM pet WHERE pet_type = '".$pet_type."';";
}
else if(empty($pet_type) && !empty($location)){
    $general_query = "SELECT pet_id, pet_name, pet_type, location FROM pet WHERE location = '".$location."';";
}
else if(!empty($pet_type) && !empty($location)){
    $general_query = "SELECT pet_id, pet_name, pet_type, location FROM pet WHERE pet_type = '".$pet_type."' AND location = '".$location."';";
}
else{
    $general_query = "SELECT pet_id, pet_name, pet_type, location FROM pet";
}

echo $general_query;

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
    echo "</tr><tr>";
    while($row = mysqli_fetch_assoc($select_result)){
        $pet_id = $row['pet_id'];
        echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_id']. "</a></td>";  
        echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_name']. "</a></td>";
        echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['pet_type']. "</a></td>"; 
        echo "<td class='tableGrid'><a href='pet_information.php?edit=$pet_id' id='link1'>". $row['location']. "</a></td>";
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