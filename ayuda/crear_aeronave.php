<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";

if($_POST){
    $modelo = $conexion->real_escape_string($_POST['modelo']);
    $matricula = $conexion->real_escape_string($_POST['matricula']);
    $capacidad = (int)($_POST['capacidad'] ?? 100);
    
    $st = $conexion->prepare("INSERT INTO aeronaves (modelo, matricula, capacidad, estado) VALUES (?,?,?,'Operativa')");
    $st->bind_param("ssi",$modelo,$matricula,$capacidad);
    $st->execute();
    echo "<div class='container'><div class='alert alert-success'>Aeronave registrada correctamente.</div><a href='panel_administrador.php'>Volver</a></div>";
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Registrar Aeronave</div><div><a href="panel_administrador.php">Volver</a></div></div>
  <h2>Registrar Aeronave</h2>
  <form method="POST">
    <label>Modelo</label><input name="modelo" required>
    <label>Matrícula</label><input name="matricula" required>
    <label>Capacidad (pasajeros)</label><input type="number" name="capacidad" min="1" value="100" required>
    <button>Registrar Aeronave</button>
  </form>
</div>
