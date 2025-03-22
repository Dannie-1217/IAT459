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
echo "<h1>Pet Information: </h1>";

require('footer.php');
?>