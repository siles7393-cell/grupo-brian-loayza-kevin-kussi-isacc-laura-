<?php
session_start();
if(!isset($_SESSION['id'])) { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";

$uid = (int)$_SESSION['id'];
$rol = $_SESSION['rol'];

// Roles de empleados que pueden crear incidencias
$roles_empleados = ['Piloto', 'Tripulacion', 'Mantenimiento', 'Operaciones'];

if(!in_array($rol, $roles_empleados)) {
    echo "<div class='container'><div class='alert alert-error'>No tienes permiso para crear incidencias</div></div>";
    exit;
}

if($_POST){
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $st = $conexion->prepare("INSERT INTO incidencias (descripcion, reportado_por, estado) VALUES (?,?,'Abierto')");
    $st->bind_param("si",$descripcion,$uid); $st->execute();
    echo "<div class='container'><div class='alert alert-success'>Incidencia creada correctamente.</div><a href='incidencias.php'>Volver</a></div>";
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Crear Incidencia</div><div><a href="incidencias.php">Volver</a></div></div>
  <h2>Reportar Incidencia</h2>
  <form method="POST">
    <label>Descripción de la Incidencia</label>
    <textarea name="descripcion" rows="6" required></textarea>
    <button>Crear Incidencia</button>
  </form>
</div>
