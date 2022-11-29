<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/add-clothing.css">
    <title>Add clothing</title>

</head>

<body>

    <div class="main-container">
        <?php include('nav.php'); ?>

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
                        <option value="Shirts">Shirts</option>
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