<?php
session_start();
include "conexion.php";
$usuario = $conexion->real_escape_string($_POST['usuario']);
$pass = $_POST['pass'];

$st = $conexion->prepare("SELECT id, pass, rol FROM usuarios WHERE usuario = ? LIMIT 1");
$st->bind_param("s",$usuario);
$st->execute();
$res = $st->get_result();
if($res->num_rows==0){ echo "Usuario no encontrado"; exit; }
$row = $res->fetch_assoc();
if(password_verify($pass, $row['pass'])) {
    $_SESSION['id'] = $row['id'];
    $_SESSION['rol'] = $row['rol'];
    header("Location: panel_router.php");
    exit;
} else {
    echo "Credenciales inválidas";
}
?>

