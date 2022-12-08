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
                    <?php if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                    <label>Name</label>
                    <input id="name" name="name" type="text">
                    <select class="category" name="category">
                        <?php
                        $categories = ['Shirts', 'Jackets', 'Pants', 'Shoes', 'Socks', 'Accessories'];
                        foreach ($categories as $category) { ?>
                            <option value="<?= $category ?>"><?= $category?></option>
                        <?php } ?>
                    </select>
                    <label class="upload-file">
                        <input type="file" name="file"/>
                        Upload file
                    </label>

<!--                    <input type="file" name="file">-->
                    <button class="confirm-upload" type="submit">Add clothing</button>
                </form>
            </section>

        </main>

    </div>

</body>