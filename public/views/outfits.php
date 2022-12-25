<?php
if(!isset($_COOKIE['user'])) {
    $url = "http://$_SERVER[HTTP_HOST]";
    header("Location: ${url}/index");
} else {
    setcookie('user', $_COOKIE['user'], time() + (60 * 20), "/");
}

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/outfits.css">
    <script type="text/javascript" src="./public/js/sidenav.js" defer></script>
    <title>Outfits</title>
</head>

<body>

<div class="main-container">

    <?php include('nav.php'); ?>

    <main class="outfits-main">

        <div class="nav">
            <div class="hamburger-container">
                <img class="hamburger" src="public/img/hamburger.svg" onclick="openNav()">
            </div>
            <h1 class="prompt">Here are your outfits:</h1>
            <div class="empty-placeholder"></div>
        </div>

        <?php
        if(isset($allOutfits)) {
            foreach($allOutfits as $outfit) {
                AppController::includeWithVariables('public/views/outfit.php',
                    ['outfit' => $outfit]);
                ?> <?php
            } }
        ?>


</div>

</div>


</body>