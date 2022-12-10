<section class="clothing-section">
    <?php if(isset($category)) { ?>
        <label class="clothing-section-label"><?=$category ?></label>
    <?php } ?>
    <div class="image-space">
        <?php if(isset($allClothing)) {
            foreach ($allClothing as $clothing) {
                if($clothing->getCategory()->getName() === $category) { ?>
                    <div class="clothing-part">
                        <img src="public/uploads/<?= $clothing->getImage() ?>" class="clothing-image">
                        <h2><?= $clothing->getName()?></h2>
                    </div>
            <?php } } ?>
        <?php } ?>
    </div>
</section>