<?php
session_start();
include "conexion.php";
$id = (int)$_POST['reserva_id'];
// Podrías validar que el pasajero sea dueño de la reserva
$conexion->query("UPDATE reservas SET estado='Cancelada' WHERE id = $id");
header("Location: mis_reservas.php");
exit;
