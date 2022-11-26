<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/add-clothing.css">
    <title>Add clothing</title>

</head>

<body>
    
    <div class="main-container">
        <nav class="sidenav">
            <label class="nav-label">Your Virtual Wardrobe</label>
    
            <a href="./wardrobe">Wardrobe</a>
            <a href="./randomizer">Outfit randomizer</a>
            <a href="./picker">Outfit picker</a>
            <a href="./favourites">Favourite outfits</a>
        </nav>
    
        <main>

            <section class="clothing-upload">
                <h1>Upload photo</h1>
                <form action="addClothing" method="POST" enctype="multipart/form-data">
<!--                    --><?php //if(isset($messages)) {
//                        foreach ($messages as $message) {
//                            echo $message;
//                        }
//                    }
//                    ?>
                    <label>Name</label>
                    <input id="name" name="name" type="text">
                    <select class="category" name="category">
                        <option value="shirts">Shirts</option>
                        <option value="Jackets">Jackets</option>
                        <option value="Pants">Pants</option>
                        <option value="Socks">Socks</option>
                        <option value="Shoes">Shoes</option>
                        <option value="Accessories">Accessories</option>
                    </select>
                    <label class="upload-file">
                        <input type="file" name="file">
                        Upload file
                    </label>
                    <button class="confirm-upload" type="submit">Add clothing</button>
                </form>
            </section>

            <section class="clothing-section">
                <label class="clothing-section-label">Shirts</label>
                <div class="image-space">
                    <?php if(isset($clothing)) { ?>
                        <img src="public/uploads/<?= $clothing->getImage() ?>">
                        <h2><?= $clothing->getName()?></h2>
                        <p><?= $clothing->getCategory()?></p>
                    <?php } else { ?>
                        <p>No clothes so far. Add some</p>
                    <?php } ?>
                </div>
            </section>

            <section class="clothing-section">
                <label class="clothing-section-label">Jackets</label>
                <div class="image-space">
                    
                </div>
            </section>

            <section class="clothing-section">
                <label class="clothing-section-label">Pants</label>
                <div class="image-space">
                    
                </div>
            </section>

            <section class="clothing-section">
                <label class="clothing-section-label">Socks</label>
                <div class="image-space">
                    
                </div>
            </section>

            
            <section class="clothing-section">
                <label class="clothing-section-label">Shoes</label>
                <div class="image-space">
                    <img>

                    <img>
                </div>
            </section>

            <section class="clothing-section">
                <label class="clothing-section-label">Accessories</label>
                <div class="image-space">
                    
                </div>
            </section>
    
        </main>

    </div>
  
    

    

    
</body>