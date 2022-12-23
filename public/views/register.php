<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/register.css">
    <script type="text/javascript" src="./public/js/script.js" defer></script>
    <title>Register Page</title>

</head>

<body>

    <div class="page-container">

        <div class="register-form-container">
            <form class="register-form" action="register" method="POST" onsubmit="return validateForm();">

                <div class="register-label-container">
                    <h1>Register</h1>
                </div>

                <div class="input-container">
                    <label>Name</label>
                    <input name="name" type="text">
                </div>

                <div class="input-container">
                    <label>Surname</label>
                    <input name="surname" type="text">
                </div>

                <div class="input-container">
                    <label>Email</label>
                    <input name="email" type="text">
                </div>

                <div class="input-container">
                    <label>Password</label>
                    <input name="password" type="password">
                </div>

                <div class="input-container">
                    <label>Confirm password</label>
                    <input name="confirm-password" type="password">
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