<?php
// conexion.php - usa en todos los archivos
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "sigea";

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Error conexión DB: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
?>
