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
    <link rel="stylesheet" href="/assets/css/registration-styles.css">
    <title>Register | Messenger</title>
</head>
<body>
    <div class = "main-container">
        <div class = "top-container">
            <span class = "register-logo-container">
                <img class="logo-img"src="/assets/images/logo.png"><h1 class = "register-title">Messenger</h1>
            </span>
        </div>
        <?php
            if (isset($_GET['reg-err'])) {
                echo "<div class='register-error'>".$_GET['reg-err']."</div>";
            }
        ?>
        <div class = "bottom-container">
            <div class = "login-container">
                <div class = "register-card">
                    <form class = "register-form" action="/assets/php/register_validation.php" method="POST">
                        <input type="text" id="username" name="username" placeholder="Username (Max 20 chars)">
                        <input type="password" id="password" name="password" placeholder="Password (Max 20 chars)">
                        <input type="password" id="repassword" name="repassword" placeholder="Re-Enter Password">
                        <button class="register-btn" type="submit">Create</button>
                        <hr class = "line">
                        <a class="sign-in-redirect-btn" href="/index.php">Sign In</a>
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