<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <title>Login Page</title>
</head>

<body>
    <div class="page-container">

        <section class="titles">
            <h1>Welcome to Your Virtual Wardrobe!</h1>
            <h2>A place for all your clothes and accessories</h2>
        </section>


        <div class="content-container">

            <div class="picture">
                <img id="man" src="public/img/mirror_man.svg">
            </div>

            <div class="forms">
                <section class="login-container">
                    <form class="login-form" action="login" method="POST">

                        <div class="login-label-container">
                            <h3>Login</h3>
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

                        <div class="login-button-container">
                            <button class="login-button" type="submit">Login</button>
                        </div>
                    </form>
                </section>
    
                <section class="register-container">
                    <label class="account-question">Don't have an account?</label>
                    <form id="register-redirect-form" action="registerUser" method="post">
                        <button id="register-redirect-button" name="register">Register</button>
                    </form>
                </section>
            </div>
            
        </div>
    </div>
</body>