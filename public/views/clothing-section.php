<section class="clothing-section">
    <?php if(isset($category)) { ?>
        <label class="clothing-section-label"><?=$category ?></label>
    <?php } ?>
    <div class="image-space">
        <?php if(isset($allClothing)) {
            foreach ($allClothing as $clothing) {
//                var_dump($clothing->getCategory()->getName());
//                var_dump($category);
                if($clothing->getCategory()->getName() === $category) { ?>
                    <img src="public/uploads/<?= $clothing->getImage() ?>">
                    <h2><?= $clothing->getName()?></h2>
                    <p><?= $clothing->getCategory()->getName()?></p>
            <?php } } ?>
        <?php } ?>
    </div>
</section>