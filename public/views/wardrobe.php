<?php
if(!isset($_COOKIE['user'])) {
    $url = "http://$_SERVER[HTTP_HOST]";
    header("Location: ${url}/index");
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
                <a href="./addClothing">Add clothes</a>
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