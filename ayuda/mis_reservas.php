<?php
session_start();
if(!isset($_SESSION['pasajero_id'])) { header("Location: login_pasajero.php"); exit; }
include "conexion.php";
include "style_head.php";
$pid = (int)$_SESSION['pasajero_id'];
$q = $conexion->prepare("SELECT r.*, v.numero, v.origen, v.destino, v.fecha_inicio FROM reservas r JOIN vuelos v ON r.vuelo_id = v.id WHERE r.pasajero_id = ?");
$q->bind_param("i",$pid); $q->execute(); $res = $q->get_result();
?>
<div class="container">
  <div class="navbar"><div>Mis Reservas</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h2>Reservas</h2>
  <?php while($r = $res->fetch_assoc()): ?>
    <div class="card">
      <b>Vuelo <?=$r['numero']?></b> <?=$r['origen']?>→<?=$r['destino']?><br>
      Fecha: <?=$r['fecha_inicio']?> - Estado: <?=$r['estado']?>
      <form method="POST" action="cancelar_reserva.php" style="margin-top:8px">
        <input type="hidden" name="reserva_id" value="<?=$r['id']?>">
        <button class="secondary">Cancelar</button>
      </form>
    </div>
  <?php endwhile; ?>
</div>
