<?php
session_start();
if(!isset($_SESSION['id'])) { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";

$id = (int)$_GET['id'];
$inc = $conexion->query("SELECT i.*, u.usuario FROM incidencias i 
                        LEFT JOIN usuarios u ON i.reportado_por = u.id 
                        WHERE i.id = $id")->fetch_assoc();

if(!$inc) {
    echo "<div class='container'><div class='alert alert-error'>Incidencia no encontrada</div></div>";
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Detalle Incidencia #<?=$id?></div><div><a href="incidencias.php">Volver</a></div></div>
  <h2>Incidencia #<?=$id?></h2>
  <p><strong>Reportado por:</strong> <?=$inc['usuario']?></p>
  <p><strong>Estado:</strong> <?=$inc['estado']?></p>
  <p><strong>Fecha:</strong> <?=$inc['fecha']?></p>
  <p><strong>Descripción:</strong></p>
  <p><?=nl2br(htmlspecialchars($inc['descripcion']))?></p>
</div>
