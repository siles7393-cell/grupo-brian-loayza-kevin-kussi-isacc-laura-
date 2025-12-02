<?php
session_start();
if(!isset($_SESSION['pasajero_id'])) { header("Location: login_pasajero.php"); exit; }
include "conexion.php";
include "functions.php";

$vuelo_id = (int)$_POST['vuelo_id'];
$asiento = $conexion->real_escape_string($_POST['asiento']?: null);
$pasajero_id = (int)$_SESSION['pasajero_id'];

// comprobar cupo
$cap = capacidad_aeronave($conexion, (int)$conexion->query("SELECT aeronave_id FROM vuelos WHERE id=$vuelo_id")->fetch_assoc()['aeronave_id']);
$resCnt = contar_reservas_vuelo($conexion, $vuelo_id);
if($resCnt >= $cap) { die("No quedan asientos en este vuelo."); }

// insertar pasajero (si el usuario no tiene perfil completo ya lo fue creado)
$st = $conexion->prepare("INSERT INTO reservas (vuelo_id, pasajero_id, asiento) VALUES (?,?,?)");
$st->bind_param("iis", $vuelo_id, $pasajero_id, $asiento);
$st->execute();
header("Location: mis_reservas.php");
exit;
