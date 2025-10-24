<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){ exit('Solo POST'); }

$content = trim($_POST['content']??'');
if($content===''){ exit('Mensaje vacío'); }

$user_id = $_SESSION['user_id'] ?? null;
$guest_name = $user_id ? null : $_SESSION['guest_name'] ?? 'Guest';

$stmt = $pdo->prepare("INSERT INTO messages (user_id, guest_name, content, ip) VALUES (?, ?, ?, ?)");
try{
    $stmt->execute([$user_id,$guest_name,$content,$_SERVER['REMOTE_ADDR']]);
    echo "OK";
}catch(PDOException $e){
    echo "Error al enviar mensaje";
}
