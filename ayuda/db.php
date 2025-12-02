<?php
$conexion = new mysqli("localhost", "root", "", "sigea");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
