<?php
session_start();
if(!isset($_SESSION['id'])) { header("Location: index.php"); exit; }
include "conexion.php";

$uid = (int)$_SESSION['id'];
$rol = $_SESSION['rol'];

// Roles que pueden cambiar incidencias
$roles_permitidos = ['Operaciones', 'Administrador'];

if(!in_array($rol, $roles_permitidos)) {
    echo "No tienes permiso para cambiar incidencias";
    exit;
}

$id = (int)$_POST['id'];
$estado = $conexion->real_escape_string($_POST['estado']);
$conexion->query("UPDATE incidencias SET estado = '$estado' WHERE id = $id");
header("Location: incidencias.php");
exit;
?>
