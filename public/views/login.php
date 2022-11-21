<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <title>Login Page</title>

</head>

<body>
    <div class="page-container">


        <h1 id="welcome-message">Welcome to Your Virtual Wardrobe!</h1>
        <h2 id="description">A place for all your clothes and accessories.</h2>    
        

        <div class="content-container">

            <div class="picture">
                <img id="man" src="public/img/mirror_man.svg">
            </div>
           
            <div class="forms-container">
                <div class="login-container">
                    <form id="form-login" action="login" method="POST">

                        <label class="form-title">Login</label>

                        <div class="messages">
                            <?php if(isset($messages)) {
                                foreach ($messages as $message) {
                                    echo $message;
                                }
                            }
                            ?>
                        </div>

                        <div id="username-container" class="input-container">
                            <label id="username-title">Username</label>
                            <input id="email-input" name="email" type="text">
                        </div>

                        <div id="password-container" class="input-container">
                            <label id="password-title">Password</label>
                            <input id="password-input" name="password" type="password">
                        </div>
                        
                        <button id="login-button" type="submit">Login</button>
                    </form>
                </div>
    
                <div class="register-container">
                    <p id="account-question">Don't have an account?</p>
                    <form id="register-redirect-form" action="register" method="get">
                        <button id="register-redirect-button">Register</button>
                    </form>
                </div>          
            </div>
            
        </div>
    </div>
</body>