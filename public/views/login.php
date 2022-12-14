<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="stylesheet" href="public/css/login-register-style/login-style.css">
        <link rel="stylesheet" href="public/css/login-register-style/login-mobile-style.css" media="(max-width:912px)">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Graduate">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

        <script src="public/scripts/show-message-error.js" defer></script>

        <title>Login page</title>
    </head>

    <body>
        <div class="container">
            <div class="box">
                <div class="text">
                    <div class="title">
                        clock around the world
                    </div>

                    <div class="description">
                        clock in every place in the world
                    </div>
                </div>
                <div class="login-form">
                    <form action="login" method="POST">
                        <div class="form-title">
                            Login to app
                        </div>
                        <div class="error">
                            <?php
                                if(isset($messages)) {
                                    foreach ($messages as $message) {
                                    echo "$message";
                                    }
                                }
                            ?>
                        </div>
                        <div class="input-control">
                            <label for="email">Login</label>
                            <input name="email" type="text" placeholder="example@mail.com">
                        </div>
                        <div class="input-control">
                            <label for="password">Password</label>
                            <input name="password" type="password" placeholder="password">
                        </div>
                        <button type="submit">Login</button>
                        <a class="register-link" href="register">or sing up here</a>
                    </form>
                </div>

                <div class="language">
                    <select>
                        <option class="lang">
                            <div>EN</div>
                        </option>
                        <option class="lang">
                            <div>PL</div>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </body>
</html>