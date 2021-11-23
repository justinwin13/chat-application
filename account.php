<?php 
    session_start();
    if (isset($_SESSION['uid'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/global-styles.css">
    <link rel="stylesheet" href="/assets/css/account-styles.css">
    <link rel="stylesheet" href="/assets/css/nav-bar-styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/cecb91c862.js" crossorigin="anonymous"></script>
    <title>Account | Messenger</title>
</head>
<body>
    <main>
    <?php 
        include './assets/php/nav_bar.php';
    ?>
        <div class="account-card">
            <form class="update-form" method="POST" action="./assets/php/update_settings.php">
                <h1 class="account-title">My Account</h1>
                <div class="account-wrapper">
                    <h3 class="account-display">Display Name</h3>
                    <?php 
                        if (isset($_SESSION['display'])) {
                            echo '<input type="text" name="display" id="display" class="display" value="'.$_SESSION['display'].'"></input>';
                        }
                        else {
                            echo '<input type="text" name="display" id="display" class="display" placeholder="Enter a Display Name"></input>';
                        }
                    ?>
                </div>
                <div class="account-wrapper">
                    <h3 class="account-username">Username</h3>
                <?php echo '<p class="username">'.$_SESSION['username'].'</p>'; ?>
                </div>
                <div class="account-wrapper">
                <h3 class="account-password">Password</h3>
                <?php echo '<input type="password" name="password" id="password" class="password" value="'.$_SESSION['password'].'"></input>'; ?>
                </div>
                <div class="logout-wrapper">
                    <button type="submit" class="save-btn">Save</button><div class="logout">Logout </div>
                </div>
            </form>
        </div>
    </main>
    <script src="/assets/js/nav-bar-script.js"></script>
</body>
</html>
<?php
    }
    else {
        header("Location: /index.php");
        exit();
    }
?>