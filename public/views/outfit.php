<div class="outfit">
    <?php
    require_once __DIR__.'/../../src/models/Category.php';
//    var_dump(__DIR__);
    $categories = Category::$VALUES;
    foreach($categories as $category) {
        if(isset($outfit)) {
            $allOutfitsParts = $outfit->getClothingPieces();
            $outfitPart = null;
            foreach ($allOutfitsParts as $currentOutfitPart) {
                if($currentOutfitPart->getCategory()->getName() === $category) {
                    $outfitPart = $currentOutfitPart;
                }
            }
//            var_dump($outfitPart);
            AppController::includeWithVariables('public/views/outfit-part.php',
                ['category' => $category, 'outfitPart' => $outfitPart]);
        }
    }
    ?>

</div>