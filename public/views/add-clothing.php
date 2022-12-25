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
    <link rel="stylesheet" type="text/css" href="public/css/add-clothing.css">
    <script type="text/javascript" src="./public/js/sidenav.js" defer></script>
    <script type="text/javascript" src="./public/js/current-page.js" defer></script>
    <title>Add clothing</title>

</head>

<body>

    <div class="main-container">
        <?php include('nav.php'); ?>

        <main>

            <section class="clothing-upload">

                <div class="nav">
                    <div class="hamburger-container">
                        <img class="hamburger" src="public/img/hamburger.svg" onclick="openNav()">
                    </div>
                    <h1>Upload photo</h1>
                    <div class="empty-placeholder"></div>
                </div>
                <form action="addClothing" method="POST" enctype="multipart/form-data">
                    <label>Name</label>
                    <input id="name" name="name" type="text">
                    <select name="category">
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

                    <div class="messages">
                        <?php if(isset($messages)) {
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }
                        ?>
                    </div>

                </form>
            </section>

        </main>

    </div>

</body>