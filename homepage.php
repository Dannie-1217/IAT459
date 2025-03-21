<?php
// Connect to the database.
require("db.php");

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()){
    echo "connection error!";
    die(mysqli_connect_error());
}
?>

<?php
//Set CSS file.
echo '<style>'; 
include "Formstyle.css"; 
echo '</style>';

require('header.php');
echo "<h1>Pet List: </h1>";

$general_query = "SELECT pet_id, pet_name, pet_type, location FROM pet";

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
        echo "<td class='tableGrid'>". $row['pet_id']. " </td>";  
        echo "<td class='tableGrid'>". $row['pet_name']. " </td>";
        echo "<td class='tableGrid'>". $row['pet_type']. " </td>"; 
        echo "<td class='tableGrid'>". $row['location']. " </td>";
        echo"</tr>";
    }
    echo"</table>";
}
//If result is empty, then show this warning.
else{
    echo"<tr>Result is empty!</tr>";
    echo"<tr><p class='warning'>Please check the date form (YYYY-MM-DD) or change the date!</p></tr>";
}


require('footer.php');
?>