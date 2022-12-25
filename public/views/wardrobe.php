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
    <link rel="stylesheet" type="text/css" href="public/css/wardrobe.css">
    <script type="text/javascript" src="./public/js/sidenav.js" defer></script>
    <script type="text/javascript" src="./public/js/current-page.js" defer></script>
    <title>Wardrobe</title>
</head>
<body>
        <div class="main-container">
            <?php include('nav.php'); ?>
            <main>
                <div class="actionButtons">
                    <div class="hamburger-container">
                        <img class="hamburger" src="public/img/hamburger.svg" onclick="openNav()">
                    </div>
<!--                    <button class="open-sidenav" onclick="openNav()">Open sidenav</button>-->
                    <a href="./addClothing">Add clothes</a>
                    <a href="./deleteClothing">Remove clothes</a>
                </div>
                <?php
                foreach (['Shirts', 'Jackets', 'Pants', 'Shoes','Socks', 'Accessories'] as $category) {
                    if(isset($allClothing)) {
                        AppController::includeWithVariables('public/views/clothing-section.php',
                            ['category' => $category, 'allClothing' => $allClothing]);
                    }
                } ?>
            </main>
        </div>
</body>