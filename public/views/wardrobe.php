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
    <title>Wardrobe</title>
</head>
<body>
        <div class="main-container">
            <?php include('nav.php'); ?>
            <main>
                <div class="actionButtons">
                    <a href="./addClothing">Add clothes</a>
                    <a href="./deleteClothing">Remove clothes</a>
                </div>
                <?php
//                var_dump($allClothing);
                foreach (['Shirts', 'Jackets', 'Pants', 'Shoes','Socks', 'Accessories'] as $category) {
                    if(isset($allClothing)) {
                        AppController::includeWithVariables('public/views/clothing-section.php',
                            ['category' => $category, 'allClothing' => $allClothing]);
                    }
                } ?>
            </main>
        </div>
</body>