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
    <script type="text/javascript" src="./public/js/delete-clothing.js" defer></script>
    <title>Delete clothing</title>
</head>
<body>
<div class="main-container">
    <?php include('nav.php'); ?>
    <main>
        <?php
        //                var_dump($allClothing);
        foreach (['Shirts', 'Jackets', 'Pants', 'Shoes','Socks', 'Accessories'] as $category) {
            if(isset($allClothing)) {
                AppController::includeWithVariables('public/views/delete-clothing-section.php',
                    ['category' => $category, 'allClothing' => $allClothing]);
            }
        } ?>
        <form>
            <button id="deleteButton">Delete selected pieces of clothing</button>
        </form>
    </main>
</div>
</body>