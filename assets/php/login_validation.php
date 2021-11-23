<?php
    session_start();
    include 'db_connection.php';
    if(isset($_POST['username']) && isset($_POST['password'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        $select = $db->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $select->bindparam(1, $username);
        $select->bindparam(2, $password);
        $select->execute();
        if ($select->rowCount() > 0) {
            $result = $select->fetch(PDO::FETCH_ASSOC);
            $update = $db->prepare("UPDATE users SET status = 1 WHERE uid = ?");
            $uid = $result['uid'];
            $update->bindparam(1, $uid);
            $update->execute();
            $_SESSION['username'] = $result['username'];
            $_SESSION['password'] = $result['password'];
            $_SESSION['uid'] = $result['uid'];
            $_SESSION['display'] = $result['displayname'];
            header("Location: /home.php");
            exit();
        }
        else {
            header("Location: /index.php?login-err=Incorrect Username or Password");
            exit();
        }

    }
    else {
        header("Location: /index.php");
        exit();
    }
?>