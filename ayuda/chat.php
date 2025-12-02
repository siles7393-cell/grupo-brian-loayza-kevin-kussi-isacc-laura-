<?php
session_start();
include "conexion.php";
include "style_head.php";
$canal = $_GET['canal'] ?? 'global';
if($_POST && isset($_POST['mensaje']) && isset($_SESSION['id'])){
    $msg = $conexion->real_escape_string($_POST['mensaje']);
    $uid = (int)$_SESSION['id'];
    $can = $conexion->real_escape_string($_POST['canal'] ?? 'global');
    $ins = $conexion->prepare("INSERT INTO chat (usuario_id, mensaje, canal) VALUES (?,?,?)");
    $ins->bind_param("iss",$uid,$msg,$can); $ins->execute();
    header("Location: chat.php?canal=".$can);
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Chat</div><div><a href="panel_router.php">Volver</a></div></div>
  <h2>Canal: <?=$canal?></h2>
  <div style="height:300px;overflow:auto;background:#fff;padding:10px;border-radius:6px">
    <?php $q = $conexion->prepare("SELECT c.*, u.usuario FROM chat c LEFT JOIN usuarios u ON c.usuario_id=u.id WHERE canal = ? ORDER BY fecha ASC");
    $q->bind_param("s",$canal); $q->execute(); $res = $q->get_result();
    while($m = $res->fetch_assoc()) echo "<p><b>{$m['usuario']}</b>: {$m['mensaje']} <span class='small'>{$m['fecha']}</span></p>";
    ?>
  </div>
  <form method="POST">
    <input name="mensaje" placeholder="Escribe..." required>
    <input type="hidden" name="canal" value="<?=$canal?>">
    <button>Enviar</button>
  </form>
</div>

