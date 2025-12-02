<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador'){ header("Location: index.php"); exit; }
include "conexion.php";
include "functions.php";
include "style_head.php";

$numero = $conexion->real_escape_string($_POST['numero']);
$origen = $conexion->real_escape_string($_POST['origen']);
$destino = $conexion->real_escape_string($_POST['destino']);
$fecha_inicio = $conexion->real_escape_string($_POST['fecha_inicio']);
$fecha_fin = $conexion->real_escape_string($_POST['fecha_fin']);
$aeronave_id = (int)$_POST['aeronave_id'];
$piloto_id = (int)$_POST['piloto_id'];
$tripulacion_ids = isset($_POST['tripulacion_ids']) ? $_POST['tripulacion_ids'] : [];
$duracion_horas = max(1, (int)$_POST['duracion_horas']);

$minDate = date("Y-m-d H:i:s", strtotime('+1 day'));
if ($fecha_inicio < $minDate || $fecha_fin < $minDate) die("Fechas deben ser a partir de mañana.");
if ($fecha_inicio >= $fecha_fin) die("Fecha inicio debe ser anterior a fecha fin.");

// 1) verificar aeronave operativa
$st = $conexion->prepare("SELECT estado, capacidad FROM aeronaves WHERE id = ? LIMIT 1");
$st->bind_param("i",$aeronave_id); $st->execute(); $r = $st->get_result()->fetch_assoc();
if(!$r) die("Aeronave no encontrada.");
if($r['estado'] != 'Operativa') die("Aeronave no operativa.");
$capacidad = (int)$r['capacidad'];

// 2) comprobar disponibilidad piloto y tripulación (incluye descanso)
$rest_hours = calcular_descanso_horas($duracion_horas);
$descanso_fin = date("Y-m-d H:i:s", strtotime($fecha_fin . " +{$rest_hours} hours"));

// comprobar piloto
if(!empleado_disponible($conexion, $piloto_id, $fecha_inicio, $descanso_fin)) die("Piloto no disponible en ese rango (incluye descanso).");

// comprobar trip
foreach($tripulacion_ids as $tid){
    $tid = (int)$tid;
    if(!empleado_disponible($conexion, $tid, $fecha_inicio, $descanso_fin)) die("Miembro de tripulación (ID $tid) no disponible en ese rango.");
}

// 3) insertar vuelo
$estado = 'Programado';
$ins = $conexion->prepare("INSERT INTO vuelos (numero, origen, destino, fecha_inicio, fecha_fin, aeronave_id, piloto_id, estado, duracion_horas) VALUES (?,?,?,?,?,?,?,?,?)");
$ins->bind_param("sssssiisi", $numero, $origen, $destino, $fecha_inicio, $fecha_fin, $aeronave_id, $piloto_id, $estado, $duracion_horas);
$ins->execute();
$vuelo_id = $conexion->insert_id;

// 4) insertar bloqueos para piloto (ocupado + descanso)
$ref = "vuelo:{$vuelo_id}";
$insd = $conexion->prepare("INSERT INTO disponibilidades_empleado (empleado_id, inicio, fin, tipo, referencia_tipo) VALUES (?,?,?,?,?)");

// ocupado piloto
$tipo = 'ocupado';
$insd->bind_param("issss", $piloto_id, $fecha_inicio, $fecha_fin, $tipo, $ref); $insd->execute();
// descanso piloto
$tipo = 'descanso';
$insd->bind_param("issss", $piloto_id, $fecha_fin, $descanso_fin, $tipo, $ref); $insd->execute();

// 5) insertar tripulacion en vuelos_personal y bloquearles
$insvp = $conexion->prepare("INSERT INTO vuelos_personal (vuelo_id, empleado_id, rol_en_vuelo) VALUES (?,?,'Tripulacion')");
foreach($tripulacion_ids as $tid){
    $tid = (int)$tid;
    $insvp->bind_param("ii", $vuelo_id, $tid); $insvp->execute();
    // bloquear ocupado
    $tipo = 'ocupado';
    $insd->bind_param("issss", $tid, $fecha_inicio, $fecha_fin, $tipo, $ref); $insd->execute();
    // bloquear descanso
    $tipo = 'descanso';
    $insd->bind_param("issss", $tid, $fecha_fin, $descanso_fin, $tipo, $ref); $insd->execute();
}

echo "<div class='container'><div class='alert alert-success'>Vuelo creado. ID: $vuelo_id</div><a href='panel_administrador.php'>Volver</a></div>";
?>

