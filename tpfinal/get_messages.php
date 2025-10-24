<?php
require 'config.php';
$limit = 100;

$sql = "SELECT m.id,m.content,m.created_at,m.user_id,m.guest_name,u.username 
        FROM messages m LEFT JOIN users u ON m.user_id=u.id 
        ORDER BY m.id DESC LIMIT $limit";

$stmt = $pdo->query($sql);
$rows = array_reverse($stmt->fetchAll());

foreach($rows as $row){
    $name = $row['user_id'] ? ($row['username'] ?: 'Usuario') : ($row['guest_name'] ?: 'Invitado');
    echo "<div class='msg'><div class='meta'><strong>".e($name)."</strong> (".$row['created_at']."):</div>"
         .nl2br(e($row['content']))."</div>";
}

