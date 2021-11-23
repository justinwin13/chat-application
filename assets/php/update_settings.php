<?php 
    session_start();
    include './db_connection.php';

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['display']) && !empty($_POST['display']) && $_POST['display'] != $_SESSION['display'] && isset($_POST['password']) && !empty($_POST['password']) && $_POST['password'] != $_SESSION['password']) {
        $display = validate($_POST['display']);
        $password = validate($_POST['password']);

        try {
            $update = $db->prepare("UPDATE users SET displayname=?, password=? WHERE uid=?");
            $update->bindparam(1, $display);
            $update->bindparam(2, $password);
            $update->bindparam(3, $_SESSION['uid']);
            $update->execute();

            $_SESSION['display'] = $display;
            $_SESSION['password'] = $password;
            header("Location: /account.php?msg=Display Name and Password Updated");
            exit();
        }
        catch (Excpetion $e) {
            header("Location: /account.php?err=Error");
            exit();
        }
    
    }
    else if (isset($_POST['display']) && !empty($_POST['display']) && $_POST['display'] != $_SESSION['display']) {
        $display = validate($_POST['display']);

        try {
            $update = $db->prepare("UPDATE users SET displayname=? WHERE uid=?");
            $update->bindparam(1, $display);
            $update->bindparam(2, $_SESSION['uid']);
            $update->execute();

            $_SESSION['display'] = $display;
            header("Location: /account.php?msg=Display Name Updated");
            exit();
        }
        catch (Exception $e) {
            header("Location: /account.php?err=Error");
            exit();
        }
        
    }
    else if (isset($_POST['password']) && !empty($_POST['password']) && $_POST['password'] != $_SESSION['password']) {
        $password = validate($_POST['password']);

        try {   
            $update = $db->prepare("UPDATE users SET password=? WHERE uid=?");
            $update->bindparam(1, $password);
            $update->bindparam(2, $_SESSION['uid']);
            $update->execute();

            $_SESSION['password'] = $password;
            header("Location: /account.php?msg=Password Updated");
            exit();
        }
        catch (Exception $e) {
            header("Location: /account.php?err=Error");
            exit();
        }
        
    }
    else {
        header("Location: /account.php?msg=Nothing Changed");
        exit();
    }
    

?>