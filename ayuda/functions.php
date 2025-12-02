<?php
// functions.php - include when needed
// assumes $conexion mysqli and session started where included

function empleado_disponible($conexion, $empleado_id, $inicio, $fin) {
    // devuelve true si NO existe solapamiento en disponibilidades_empleado
    $sql = "SELECT COUNT(*) as cnt FROM disponibilidades_empleado 
            WHERE empleado_id = ? 
              AND NOT (fin <= ? OR inicio >= ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $empleado_id, $inicio, $fin);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    return ($r['cnt'] == 0);
}

function calcular_descanso_horas($duracion_horas) {
    // regla: <2h =>1h; 2-6h =>4h; >6h =>12h
    if ($duracion_horas < 2) return 1;
    if ($duracion_horas <= 6) return 4;
    return 12;
}

function contar_reservas_vuelo($conexion, $vuelo_id) {
    $sql = "SELECT COUNT(*) AS cnt FROM reservas WHERE vuelo_id = ? AND estado = 'Reservada'";
    $st = $conexion->prepare($sql);
    $st->bind_param("i", $vuelo_id);
    $st->execute();
    return $st->get_result()->fetch_assoc()['cnt'];
}

function capacidad_aeronave($conexion, $aeronave_id) {
    $sql = "SELECT capacidad FROM aeronaves WHERE id = ? LIMIT 1";
    $st = $conexion->prepare($sql);
    $st->bind_param("i", $aeronave_id);
    $st->execute();
    $r = $st->get_result()->fetch_assoc();
    return $r ? (int)$r['capacidad'] : 0;
}
?>
