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
    <link rel="stylesheet" type="text/css" href="public/css/picker.css">
    <script type="text/javascript" src="./public/js/current-page.js" defer></script>
    <title>Picker</title>
</head>
<body>
    <div class="main-container">
        <?php include('nav.php'); ?>
        <main>
            <h1 class="prompt">Choose one of each piece of clothing:</h1>
            <?php AppController::includeWithVariables('public/views/clothing-section.php', ['category' => 'Shirts']) ?>
            <?php AppController::includeWithVariables('public/views/clothing-section.php', ['category' => 'Jackets']) ?>
            <?php AppController::includeWithVariables('public/views/clothing-section.php', ['category' => 'Pants']) ?>
            <?php AppController::includeWithVariables('public/views/clothing-section.php', ['category' => 'Shoes']) ?>
            <?php AppController::includeWithVariables('public/views/clothing-section.php', ['category' => 'Accessories']) ?>
            <button id="confirm-outfit-button" class="util-button">Confirm outfit</button>
        </main>
    </div>
</body>