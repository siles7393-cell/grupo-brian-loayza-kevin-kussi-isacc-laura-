<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Operaciones') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>Operaciones</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h1>Panel Operaciones</h1>

  <div class="flex">
    <a class="btn" href="ver_vuelos_admin.php">Ver / Gestionar vuelos</a>
    <a class="btn" href="incidencias.php">Incidencias</a>
    <a class="btn" href="chat.php">Chat</a>
  </div>

  <h2 class="small">Últimos vuelos programados</h2>
  <?php
  $q = $conexion->query("SELECT v.id,v.numero,v.origen,v.destino,v.fecha_inicio,v.fecha_fin,v.estado,a.matricula
                         FROM vuelos v LEFT JOIN aeronaves a ON v.aeronave_id = a.id
                         ORDER BY v.fecha_inicio DESC LIMIT 6");
  while($r = $q->fetch_assoc()){
      echo "<div class='card'><b>{$r['numero']}</b> {$r['origen']}→{$r['destino']} ({$r['fecha_inicio']}) - Estado: {$r['estado']}<span class='small right'>Aeronave: {$r['matricula']}</span></div>";
  }
  ?>
</div>
