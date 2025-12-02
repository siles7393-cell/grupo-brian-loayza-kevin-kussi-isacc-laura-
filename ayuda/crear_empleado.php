<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";

if($_POST){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $documento = $conexion->real_escape_string($_POST['documento']);
    $rol = $conexion->real_escape_string($_POST['rol']);
    $certificaciones = $conexion->real_escape_string($_POST['certificaciones'] ?? '');
    $idiomas = $conexion->real_escape_string($_POST['idiomas'] ?? '');

    $st = $conexion->prepare("INSERT INTO empleados (nombre, documento, rol, certificaciones, idiomas, disponible) 
                              VALUES (?,?,?,?,?,1)");
    $st->bind_param("sssss",$nombre,$documento,$rol,$certificaciones,$idiomas);
    $st->execute();
    echo "<div class='container'><div class='alert alert-success'>Empleado creado correctamente.</div><a href='panel_administrador.php'>Volver</a></div>";
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Crear Empleado</div><div><a href="panel_administrador.php">Volver</a></div></div>
  <h2>Crear Empleado</h2>
  <form method="POST">
    <label>Nombre</label><input name="nombre" required>
    <label>Documento</label><input name="documento" required>
    <label>Rol</label>
    <select name="rol" required>
      <option value="Piloto">Piloto</option>
      <option value="Tripulacion">Tripulación</option>
      <option value="Mantenimiento">Mantenimiento</option>
      <option value="Operaciones">Operaciones</option>
    </select>
    <label>Certificaciones</label><textarea name="certificaciones" rows="3"></textarea>
    <label>Idiomas</label><textarea name="idiomas" rows="3"></textarea>
    <button>Crear Empleado</button>
  </form>
</div>
