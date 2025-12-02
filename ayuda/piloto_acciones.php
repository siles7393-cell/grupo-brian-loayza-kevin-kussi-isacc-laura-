<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Piloto'){ header("Location: index.php"); exit; }
include "conexion.php"; include "functions.php";
$vuelo_id = (int)$_POST['vuelo_id'];
$accion = $_POST['accion'];

if($accion == 'iniciar'){
    $conexion->query("UPDATE vuelos SET estado = 'En Vuelo' WHERE id = $vuelo_id");
    header("Location: panel_piloto.php"); exit;
}
if($accion == 'finalizar'){
    // marcar finalizado
    $conexion->query("UPDATE vuelos SET estado = 'Finalizado' WHERE id = $vuelo_id");
    // generar descanso si no existe ya
    $v = $conexion->query("SELECT fecha_fin, duracion_horas, piloto_id FROM vuelos WHERE id = $vuelo_id")->fetch_assoc();
    $dur = (int)$v['duracion_horas'];
    $rest = calcular_descanso_horas($dur);
    $inicioDesc = $v['fecha_fin'];
    $finDesc = date("Y-m-d H:i:s", strtotime($inicioDesc . " +{$rest} hours"));
    $ref = "vuelo:{$vuelo_id}";
    // insertar descanso (si no existe)
    $st = $conexion->prepare("SELECT COUNT(*) as cnt FROM disponibilidades_empleado WHERE empleado_id = ? AND inicio = ? AND fin = ?");
    $st->bind_param("iss",$v['piloto_id'],$inicioDesc,$finDesc); $st->execute(); $cnt = $st->get_result()->fetch_assoc()['cnt'];
    if($cnt==0){
        $ins = $conexion->prepare("INSERT INTO disponibilidades_empleado (empleado_id, inicio, fin, tipo, referencia_tipo) VALUES (?,?,?,?,?)");
        $tipo = 'descanso';
        $ins->bind_param("issss",$v['piloto_id'],$inicioDesc,$finDesc,$tipo,$ref); $ins->execute();
    }
    header("Location: panel_piloto.php"); exit;
}
