<div class="outfit-part">
    <?php if(isset($category)) { ?>
        <label class="outfit-part-label"><?= $category ?></label>
        <?php if(isset($outfitPart)) { ?>
            <img src="public/uploads/<?= $outfitPart->getImage() ?>" class="outfit-part-image">
            <h2 class="clothing-name"><?= $outfitPart->getName()?></h2>
    <?php } } ?>
</div>