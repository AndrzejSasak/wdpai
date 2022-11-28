<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/register.css">
    <title>Register Page</title>

</head>

<body>

    <div class="page-container">

        <div class="register-form-container">
            <form class="register-form">

                <div class="register-label-container">
                    <h1>Register</h1>
                </div>

                <div class="input-container">
                    <label>Username</label>
                    <input name="email" type="text">
                </div>

                <div class="input-container">
                    <label>Password</label>
                    <input name="password" type="password">
                </div>

                <div class="messages">
                    <?php if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>

                <div class="register-button-container">
                    <button class="register-button" type="submit">Register</button>
                </div>

            </form>
        </div>

        <div class="picture">
            <img src="public/img/woman.svg">
        </div>



    </div>

</body>