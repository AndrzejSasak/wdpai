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
                <?php foreach (['Shirts', 'Jackets', 'Pants', 'Shoes', 'Accessories'] as $category) {
                    if(isset($clothing)) {
                        AppController::includeWithVariables('public/views/clothing-section.php', ['category' => $category, 'clothing' => $clothing]);
                    } else {
                        AppController::includeWithVariables('public/views/clothing-section.php', ['category' => $category]);
                    }
                } ?>
            </main>
        </div>
</body>