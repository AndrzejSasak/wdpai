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
                <button action="addClothing" method="POST">Add clothes</button>
                <?php
//                var_dump($allClothing);
                foreach (['Shirts', 'Jackets', 'Pants', 'Shoes', 'Accessories'] as $category) {
                    if(isset($allClothing)) {
                        AppController::includeWithVariables('public/views/clothing-section.php',
                            ['category' => $category, 'allClothing' => $allClothing]);
                    }
                } ?>
            </main>
        </div>
</body>