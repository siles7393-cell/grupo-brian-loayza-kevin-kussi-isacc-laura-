<?php
session_start();
if(!isset($_SESSION['pasajero_id'])) { header("Location: login_pasajero.php"); exit; }
include "conexion.php";
include "functions.php";
include "style_head.php";

$pid = (int)$_SESSION['pasajero_id'];
$nombre = $_SESSION['pasajero_nombre'] ?? 'Pasajero';

// obtener vuelos programados con asientos disponibles
$q = $conexion->prepare("SELECT v.*, a.matricula, a.capacidad, 
    (SELECT COUNT(*) FROM reservas r WHERE r.vuelo_id=v.id AND r.estado='Reservada') AS reservadas 
    FROM vuelos v LEFT JOIN aeronaves a ON v.aeronave_id=a.id 
    WHERE v.estado = 'Programado' ORDER BY v.fecha_inicio ASC");
$q->execute();
$res = $q->get_result();
?>
<div class="container">
  <div class="navbar"><div>Pasajero: <?=htmlspecialchars($nombre)?></div><div><a href="logout_pasajero.php">Cerrar sesión</a></div></div>
  <h2>Panel Pasajero</h2>
  <div class="flex">
    <a class="btn" href="ver_vuelos_public.php">Ver Vuelos</a>
    <a class="btn" href="mis_reservas.php">Mis Reservas</a>
    
  </div>

  <h2 class="small">Próximos vuelos</h2>
  <?php while($v = $res->fetch_assoc()):
      $disponibles = ((int)$v['capacidad']) - ((int)$v['reservadas']);
  ?>
    <div class="card">
      <b><?=htmlspecialchars($v['numero'])?></b> <?=htmlspecialchars($v['origen'])?> → <?=htmlspecialchars($v['destino'])?><br>
      Inicio: <?=htmlspecialchars($v['fecha_inicio'])?> — Fin: <?=htmlspecialchars($v['fecha_fin'])?><br>
      Asientos libres: <?=$disponibles?> / <?= (int)$v['capacidad'] ?>
      <div class="flex" style="margin-top:8px">
        <a class="btn" href="detalle_vuelo_public.php?id=<?=$v['id']?>">Ver / Reservar</a>
      </div>
    </div>
  <?php endwhile; ?>

</div>
