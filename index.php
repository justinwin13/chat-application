<?php
    session_start();
    if (!isset($_SESSION['uid'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/global-styles.css">
    <link rel="stylesheet" href="/assets/css/index-styles.css">
    <title>Sign In | Messenger</title>
</head>
<body>
    <div class="main-container">
        <div class="left-container">
            <span class="index-logo-container"><img class="logo-img" src="/assets/images/logo.png"><h1 class="index-title">Messenger</h1></span>
            <p class="index-paragraph">
                Sign in or create an account to join the group chat!
            </p>
        </div>
        <div class="right-container">
            <div class="login-container">
                <?php
                    if (isset($_GET['login-err'])) {
                        echo "<div class='login-error'>".$_GET['login-err']."</div>";
                    }
                ?>
                <div class="login-card">
                    <form class="login-form" action="/assets/php/login_validation.php" method="POST">
                        <input type="text" id="username" name="username" placeholder="Username">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <button class="login-btn" type="submit">Log In</button>
                        <hr class="line">
                        <a class="register-redirect-btn" href="/registration.php">Create Account</a>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    }
    else {
        header("Location: /home.php");
        exit();
    }
?>