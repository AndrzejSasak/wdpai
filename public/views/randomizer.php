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
    <link rel="stylesheet" type="text/css" href="public/css/randomizer.css">
    <script type="text/javascript" src="./public/js/sidenav.js" defer></script>
    <script type="text/javascript" src="./public/js/current-page.js" defer></script>
    <title>Randomizer</title>
</head>

<body>

    <div class="main-container">

        <?php include('nav.php'); ?>

        <main class="outfits-main">


            <div class="buttons">
                <div class="hamburger-container">
                    <img class="hamburger" src="public/img/hamburger.svg" onclick="openNav()">
                </div>

                <form action="randomizeOutfit" method="POST" class="submitButtonForm">
                    <?php if(isset($randomizedOutfit)) { ?>
                        <button id="after-button" class="submitButton">Choose my outfit</button>
                    <?php } else { ?>
                        <button id="before-button" class="submitButton">Choose my outfit</button>
                    <?php } ?>
                </form>

                <div class="empty-placeholder">
                </div>
            </div>


            <?php if(isset($randomizedOutfit)) { ?>
            <h1 class="prompt">Your outfit for the day is:</h1>
            <?php AppController::includeWithVariables('public/views/outfit.php',
                ['outfit' => $randomizedOutfit]);
            $_SESSION['outfit'] = serialize($randomizedOutfit); ?>

            <div class="afterRandomButtons">
                <form action="saveToAllOutfits" method="POST" class="submitButtonForm">
                    <button type="submit"  class="submitButton">Save outfit</button>
                </form>
                <form action="addToFavourites" method="POST" class="submitButtonForm">
                    <button type="submit" class="submitButton">Add to favourites</button>
                </form>
            </div

            <?php } ?>

            <div class="messages">
                <?php if(isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>




            </div>

        </main>
        
    </div>
    
</body>