<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Tripulacion') { header("Location: index.php"); exit; }
include "conexion.php";
include "functions.php";
include "style_head.php";
$uid = (int)$_SESSION['id'];
$empleado_id = (int)$conexion->query("SELECT empleado_id FROM usuarios WHERE id = $uid")->fetch_assoc()['empleado_id'];

$q = $conexion->prepare("SELECT v.*, e.nombre as piloto FROM vuelos v 
                         JOIN vuelos_personal vp ON v.id = vp.vuelo_id 
                         JOIN empleados e ON v.piloto_id = e.id 
                         WHERE vp.empleado_id = ? ORDER BY v.fecha_inicio ASC");
$q->bind_param("i",$empleado_id); $q->execute(); $res = $q->get_result();
?>
<div class="container">
  <div class="navbar"><div>Tripulación</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h2>Mis Vuelos Asignados</h2>
  <?php while($v=$res->fetch_assoc()): ?>
    <div class="card">
      <b><?=$v['numero']?></b> <?=$v['origen']?>→<?=$v['destino']?><br>
      Inicio: <?=$v['fecha_inicio']?> Fin: <?=$v['fecha_fin']?> Estado: <?=$v['estado']?><br>
      Piloto: <?=$v['piloto']?>
    </div>
  <?php endwhile; ?>
</div>
