<?php 
    include 'db_connection.php';

    $select = $db->prepare("SELECT * FROM message m, users u WHERE gid=1 AND u.uid=m.uid ORDER BY timestamp ASC");
    $select->execute();
    $results = $select->fetchALL(PDO::FETCH_ASSOC);
   
    foreach ($results as $row) {
        if ($row['uid'] == $_SESSION['uid']) {
            if (empty($row['displayname'])) {
                echo '<div class="user-message-container my-msg"><h1 class="message-username">'.$row['username']." <span class='tag-line'>#".$row['uid'].'</span></h1><p class="user-message">'.$row['msg'].'</p></div>';
            }
            else {
                echo '<div class="user-message-container my-msg"><h1 class="message-username">'.$row['displayname']." <span class='tag-line'>#".$row['uid'].'</span></h1><p class="user-message">'.$row['msg'].'</p></div>';
            }
        }
        else {
            if (empty($row['displayname'])) {
                echo '<div class="user-message-container"><h1 class="message-username">'.$row['username']." <span class='tag-line'>#".$row['uid'].'</span></h1><p class="user-message">'.$row['msg'].'</p></div>';
            }
            else {
                echo '<div class="user-message-container"><h1 class="message-username">'.$row['displayname']." <span class='tag-line'>#".$row['uid'].'</span></h1><p class="user-message">'.$row['msg'].'</p></div>';
            }
        }
    }
?>