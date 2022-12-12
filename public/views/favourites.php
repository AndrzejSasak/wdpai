<?php
if(!isset($_COOKIE['user'])) {
    $url = "http://$_SERVER[HTTP_HOST]";
    header("Location: ${url}/index");
}

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/favourites.css">
    <title>Favourites</title>
</head>

<body>

    <div class="main-container">

        <?php include('nav.php'); ?>
    
        <main class="outfits-main">

            <h1 class="prompt">Your favourite outfits are:</h1>

            <?php
            if(isset($favouriteOutfits)) {
//            var_dump(sizeof($favouriteOutfits));
            foreach($favouriteOutfits as $outfit) {
                AppController::includeWithVariables('public/views/outfit.php',
                    ['outfit' => $outfit]);
                ?> <?php
            } }
            ?>
    
        </main>

    </div>
    
    
</body>