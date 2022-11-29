<section class="clothing-section">
    <?php if(isset($category)) { ?>
        <label class="clothing-section-label"><?=$category ?></label>
    <?php } ?>
    <div class="image-space">
        <?php if(isset($clothing) && $clothing->getCategory() === $category) { ?>
            <img src="public/uploads/<?= $clothing->getImage() ?>">
            <h2><?= $clothing->getName()?></h2>
            <p><?= $clothing->getCategory()?></p>
        <?php } else { ?>
            <p>So empty here ;( Add some <?= lcfirst($category) ?>!</p>
        <?php } ?>
    </div>
</section>