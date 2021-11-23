<?php
    include 'db_connection.php';

    $select = $db->prepare("SELECT u.* FROM users u, in_group i, group_chat g WHERE g.gid=1 AND g.gid=i.gid AND u.uid=i.uid");
    $select->execute();
    $results = $select->fetchALL(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        echo '<li class="member-list-item">'.$row['username'].'</li>';
    }
?>