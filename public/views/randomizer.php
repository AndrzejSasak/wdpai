<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/randomizer.css">
    <title>Randomizer</title>
</head>

<body>

    <div class="main-container">

        <?php include('nav.php'); ?>

        <main class="outfits-main">

            <form action="randomizeOutfit" method="POST">
                <button id="choose-my-outfit-button" class="util-button">Chooose my outfit</button>
            </form>

            <hr>

            <?php if(isset($randomizedOutfit)) { ?>
            <h1 class="prompt">Your outfit for the day is:</h1>

            <div class="outfit">

                <div class="outfit-part">
                    <label class="outfit-part-label">Shirt</label>
                    <?php foreach ($randomizedOutfit->getClothingPieces() as $clothingPiece) {
                        if($clothingPiece->getCategory()->getName() === "Shirts") {
                            $key = array_search($clothingPiece, $randomizedOutfit->getClothingPieces()); ?>
                            <img src="public/uploads/<?=  $randomizedOutfit->getClothingPieces()[$key]->getImage() ?>">
                        <?php } } ?>
                </div>

                <div class="outfit-part">
                    <label class="outfit-part-label">Jacket</label>
                    <?php foreach ($randomizedOutfit->getClothingPieces() as $clothingPiece) {
                        if($clothingPiece->getCategory()->getName() === "Jackets") {
                            $key = array_search($clothingPiece, $randomizedOutfit->getClothingPieces()); ?>
                            <img src="public/uploads/<?=  $randomizedOutfit->getClothingPieces()[$key]->getImage() ?>">
                        <?php } } ?>
                </div>

                <div class="outfit-part">
                    <label class="outfit-part-label">Pants</label>
                    <?php foreach ($randomizedOutfit->getClothingPieces() as $clothingPiece) {
                        if($clothingPiece->getCategory()->getName() === "Pants") {
                            $key = array_search($clothingPiece, $randomizedOutfit->getClothingPieces()); ?>
                            <img src="public/uploads/<?=  $randomizedOutfit->getClothingPieces()[$key]->getImage() ?>">
                        <?php } } ?>
                </div>

                <div class="outfit-part">
                    <label class="outfit-part-label">Socks</label>
                    <?php foreach ($randomizedOutfit->getClothingPieces() as $clothingPiece) {
                        if($clothingPiece->getCategory()->getName() === "Shoes") {
                            $key = array_search($clothingPiece, $randomizedOutfit->getClothingPieces()); ?>
                            <img src="public/uploads/<?=  $randomizedOutfit->getClothingPieces()[$key]->getImage() ?>">
                        <?php } } ?>
                </div>

                <div class="outfit-part">
                    <label class="outfit-part-label">Shoes</label>
                    <?php foreach ($randomizedOutfit->getClothingPieces() as $clothingPiece) {
                        if($clothingPiece->getCategory()->getName() === "Socks") {
                            $key = array_search($clothingPiece, $randomizedOutfit->getClothingPieces()); ?>
                            <img src="public/uploads/<?=  $randomizedOutfit->getClothingPieces()[$key]->getImage() ?>">
                        <?php } } ?>
                </div>

                <div class="outfit-part">
                    <label class="outfit-part-label">Accessories</label>
                    <?php foreach ($randomizedOutfit->getClothingPieces() as $clothingPiece) {
                        if($clothingPiece->getCategory()->getName() === "Accessories") {
                            $key = array_search($clothingPiece, $randomizedOutfit->getClothingPieces()); ?>
                            <img src="public/uploads/<?=  $randomizedOutfit->getClothingPieces()[$key]->getImage() ?>">
                        <?php } } ?>
                </div>
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