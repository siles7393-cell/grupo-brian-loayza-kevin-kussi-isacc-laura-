<?php
session_start();
include "conexion.php";
include "style_head.php";
if($_POST){
    $email = $conexion->real_escape_string($_POST['email']);
    $pass = $_POST['pass'];
    $st = $conexion->prepare("SELECT id, pass, nombre FROM pasajeros WHERE email = ? LIMIT 1");
    $st->bind_param("s",$email); $st->execute();
    $r = $st->get_result();
    if($r->num_rows==0) { $err="Usuario no encontrado"; }
    else {
        $row = $r->fetch_assoc();
        if(password_verify($pass, $row['pass'])) {
            $_SESSION['pasajero_id'] = $row['id'];
            $_SESSION['pasajero_nombre'] = $row['nombre'];
            header("Location: panel_pasajero.php"); exit;
        } else $err = "Contraseña incorrecta";
    }
}
?>

<div class="container">
  <h2>Login Pasajero</h2>
  
  <?php if(!empty($err)) echo "<div class='alert alert-error'>{$err}</div>"; ?>
  <form method="POST">
    <label>Email</label><input name="email" type="email" required>
    <label>Contraseña</label><input name="pass" type="password" required>
    <button>Entrar</button>
  </form>
  <div style="margin-top:10px; text-align:center;">
    <a class="btn" href="registrar_pasajero.php">Registrate</a>
  </div>
</div>
