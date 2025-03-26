<?php require_once("../../private/functions/initialization.php") ?>

<?php
//Set CSS file.
echo '<style>'; 
include PUBLIC_PATH."/css/Formstyle.css";
echo '</style>';

require(SHARED_PATH.'/header.php');
echo "<h1>About Us: </h1>";

require(SHARED_PATH.'/footer.php');
?>