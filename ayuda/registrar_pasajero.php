<?php
include "conexion.php";
include "style_head.php";
if($_POST){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $email  = $conexion->real_escape_string($_POST['email']);
    $pass   = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $doc    = $conexion->real_escape_string($_POST['documento']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $st = $conexion->prepare("INSERT INTO pasajeros (nombre, documento, email, telefono, pass) VALUES (?,?,?,?,?)");
    $st->bind_param("sssss",$nombre,$doc,$email,$telefono,$pass);
    $st->execute();
    echo "<div class='container'><div class='alert alert-success'>Registro correcto. Puedes iniciar sesión.</div><a href='login_pasajero.php'>Login Pasajero</a></div>";
    exit;
}
?>
<div class="container">
  <h2>Registro Pasajero</h2>
  <form method="POST">
    <label>Nombre</label><input name="nombre" required>
    <label>Email</label><input name="email" type="email" required>
    <label>Documento</label><input name="documento">
    <label>Teléfono</label><input name="telefono">
    <label>Contraseña</label><input name="pass" type="password" required>
    <button>Registrar</button>
  </form>
</div>
