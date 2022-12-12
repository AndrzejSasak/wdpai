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
<!--    TODO: change css file-->
    <title>Outfits</title>
</head>

<body>

<div class="main-container">

    <?php include('nav.php'); ?>

    <main class="outfits-main">

        <h1 class="prompt">Here are your outfits:</h1>

        <?php
        if(isset($allOutfits)) {
//            var_dump($allOutfits);
            foreach($allOutfits as $outfit) {
                AppController::includeWithVariables('public/views/outfit.php',
                    ['outfit' => $outfit]);
                ?> <?php
            } }
        ?>


</div>

</div>


</body>