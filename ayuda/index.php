<?php
session_start();
if(isset($_SESSION['id'])) {
    header("Location: panel_router.php"); exit;
}
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>SIGEA</div><div><a href="login_pasajero.php">Login Pasajero</a></div></div>
  <h2>Login - Administradores / Staff</h2>
  <form action="validar_login.php" method="POST">
    <label>Usuario</label>
    <input name="usuario" required>
    <label>Contraseña</label>
    <input name="pass" type="password" required>
    <button>Ingresar</button>
  </form>
</div>
