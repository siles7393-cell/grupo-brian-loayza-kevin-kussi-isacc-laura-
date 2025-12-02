<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { header("Location: index.php"); exit; }
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>Administrador</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h1>Panel Administrador</h1>
  <div class="flex">
    <a class="btn" href="crear_empleado.php">Crear Empleado</a>
    <a class="btn" href="crear_aeronave.php">Registrar Aeronave</a>
    <a class="btn" href="crear_vuelo.php">Crear Vuelo</a>
    <a class="btn" href="ver_reservas_admin.php">Ver Reservas</a>
  </div>
</div>
