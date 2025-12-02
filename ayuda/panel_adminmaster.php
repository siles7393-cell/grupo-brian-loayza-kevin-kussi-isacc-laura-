<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'AdminMaster') { header("Location: index.php"); exit; }
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>AdminMaster</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h1>Panel AdminMaster</h1>
  <div class="flex">
    <a class="btn" href="crear_usuario.php">Crear cuenta</a>
    <a class="btn" href="panel_administrador.php">Ir a Panel Administrador</a>
    <a class="btn" href="ver_vuelos_public.php">Ver vuelos</a>
  </div>
</div>
