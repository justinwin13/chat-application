<?php
    session_start();
    include './db_connection.php';

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword'])) {
        function validate($data) {
            $data = trim($data); // removes white spaces
            $data = stripslashes($data); // removes slashes 
            $data = htmlspecialchars($data); // converts special chars (&, <, >, ', ")
            return $data;
        }

        $username = validate($_POST['username']);   
        $password = validate($_POST['password']);   
        $repassword = validate($_POST['repassword']); 
        
        if (empty($username)) {
            header("Location: /registration.php?reg-err=Enter a Username");
            exit();
        }
        else if (empty($password)) {
            header("Location: /registration.php?reg-err=Enter a Password");
            exit();
        }
        else if (empty($repassword)) {
            header("Location: /registration.php?reg-err=Enter Password again");
            exit();
        }
        else if ($repassword != $password) {
            header("Location: /registration.php?reg-err=Passwords do not match");
            exit();
        }
        else {
            $select = $db->prepare("SELECT * FROM users WHERE username=?");
            $select->bindparam(1, $username);
            $select->execute();

            if ($select->rowCount() > 0) {
                header("Location: /registration.php?reg-err=Username is taken");
                exit();
            }
            else {
                try {
                    $insert = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                    $insert->bindparam(1, $username);
                    $insert->bindparam(2, $password);
                    $insert->execute();

                    $update = $db->prepare("UPDATE users SET status = 1 WHERE username = ?");
                    $update->bindparam(1, $username);
                    $update->execute();

                    $select = $db->prepare("SELECT * FROM users WHERE username=?");
                    $select->bindparam(1, $username);
                    $select->execute();
                    $result = $select->fetch(PDO::FETCH_ASSOC);
                    
                    $insert2 = $db->prepare("INSERT INTO in_group (gid, uid) VALUES (1, ?)");
                    $insert2->bindparam(1, $result['uid']);
                    $insert2->execute();
        
                    $_SESSION['username'] = $result['username'];
                    $_SESSION['password'] = $result['password'];
                    $_SESSION['uid'] = $result['uid'];

                    header("Location: /home.php");
                    exit();
                }
                catch (Exception $e) {
                    header("Location: /registration.php?reg-err=An error has occured. Please try again");
                    exit();
                }
            }
        }
    }
?>