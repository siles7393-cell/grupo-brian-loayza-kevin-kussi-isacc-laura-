<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Mantenimiento'){ header("Location: index.php"); exit; }
include "conexion.php"; include "style_head.php";
$id = (int)$_GET['id'];
if($_POST){
  $estado = $conexion->real_escape_string($_POST['estado']);
  $conexion->query("UPDATE aeronaves SET estado='{$estado}' WHERE id = $id");
  header("Location: panel_mantenimiento.php"); exit;
}
$a = $conexion->query("SELECT * FROM aeronaves WHERE id = $id")->fetch_assoc();
?>
<div class="container">
  <h2>Cambiar estado aeronave <?=$a['matricula']?></h2>
  <form method="POST">
    <select name="estado">
      <option value="Operativa" <?= $a['estado']=='Operativa'?'selected':'' ?>>Operativa</option>
      <option value="En Mantenimiento" <?= $a['estado']=='En Mantenimiento'?'selected':'' ?>>En Mantenimiento</option>
      <option value="Fuera de Servicio" <?= $a['estado']=='Fuera de Servicio'?'selected':'' ?>>Fuera de Servicio</option>
    </select>
    <button>Guardar</button>
  </form>
</div>

