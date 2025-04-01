<?php require_once("../../private/functions/initialization.php") ?>

<?php
//Set CSS file.
echo '<style>'; 
include ROOT_PATH . PUBLIC_PATH."/css/Formstyle.css";
echo '</style>';

require(ROOT_PATH . SHARED_PATH.'/header.php');
echo "<h1>About Us: </h1>";

require(ROOT_PATH . SHARED_PATH.'/footer.php');
?>