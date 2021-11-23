<?php
    $host = "198.71.49.185";
    $database = "chat_app";
    $username = "client";
    $password = "password";
    
    try {
        $db = new PDO("mysql:host=$host; dbname=$database", $username, $password);
        //echo 'success';
    }
    catch (Exception $e) {
        echo "<pre>".print_r($e, true)."</pre>";
    }
?>

