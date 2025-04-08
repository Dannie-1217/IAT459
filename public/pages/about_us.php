<?php require_once("../../private/functions/initialization.php") ?>

<?php

$page_styles = [
    PUBLIC_PATH . '/css/header.css',
    PUBLIC_PATH . '/css/homepage.css',
    PUBLIC_PATH . '/css/font.css',
    PUBLIC_PATH . '/css/grid.css',
    PUBLIC_PATH . '/css/footer.css',
];

require_once(ROOT_PATH . SHARED_PATH . '/header.php');
?>


<boady>
    <div style="display:grid; grid-template-columns: 2fr 2.5fr; align-items:center; height: 800px; margin-top: 3rem; margin-bottom: 3rem;">
        <div style="margin-left: 15rem; margin-right: 0rem;">
            <img src="../images/assets/about_us_paw.png" style="width:auto;height:500px; align-items:center;" alt="paw">
        </div>
        <div style="margin-right: 20rem;">
            <h1 style="font-size: 6.2rem; color:#212427;">About us</h1>
            <p style="padding-left: 2rem; line-height: 2rem;font-size: 1.8rem; color:#212427;">Welcome to FurEver Friends, a platform that design to let people post and adopt adorable pets in the Greater Vancouver area. We believe that every animal deserves a warm and sweet home in their lives, and we also believe a happy pets could bring about a happy owner. That is why we're here to facilitate free adoptions. What are you nwaiting for? Come and become a memeber to start pet adoption advantures!</p>
        </div>
    </div>

    <?php require_once(ROOT_PATH . SHARED_PATH.'/footer.php'); ?>
</body>
</html>