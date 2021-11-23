<?php
    include 'db_connection.php';

    $select = $db->prepare("SELECT g.* FROM group_chat g, users u, in_group i WHERE u.uid=? AND u.uid=i.uid AND i.gid=g.gid");
    $select->bindparam(1, $_SESSION['uid']);
    $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        echo '<li class="group-list-item">'.$row['group_name'].'</li>';
    }
?>