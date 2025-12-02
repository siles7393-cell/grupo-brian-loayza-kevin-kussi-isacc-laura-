<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Operaciones') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";
$accion = $_GET['accion'] ?? null;
$vuelo_id = (int)($_GET['id'] ?? 0);

if($_POST && isset($_POST['vuelo_id'])) {
    $vuelo_id = (int)$_POST['vuelo_id'];
    $nuevo_estado = $conexion->real_escape_string($_POST['estado']);
    $conexion->query("UPDATE vuelos SET estado = '$nuevo_estado' WHERE id = $vuelo_id");
    header("Location: ver_vuelos_admin.php");
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Gestionar Vuelos</div><div><a href="panel_operaciones.php">Volver</a></div></div>
  <h1>Vuelos</h1>
  <table>
    <tr><th>Número</th><th>Origen</th><th>Destino</th><th>Inicio</th><th>Fin</th><th>Estado</th><th>Acciones</th></tr>
    <?php
    $q = $conexion->query("SELECT * FROM vuelos ORDER BY fecha_inicio DESC");
    while($v = $q->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$v['numero']}</td>";
        echo "<td>{$v['origen']}</td>";
        echo "<td>{$v['destino']}</td>";
        echo "<td>{$v['fecha_inicio']}</td>";
        echo "<td>{$v['fecha_fin']}</td>";
        echo "<td>{$v['estado']}</td>";
        echo "<td><form method='POST' style='display:inline'>";
        echo "<input type='hidden' name='vuelo_id' value='{$v['id']}'>";
        echo "<select name='estado'>";
        echo "<option value='Programado' " . ($v['estado']=='Programado'?'selected':'') . ">Programado</option>";
        echo "<option value='En Vuelo' " . ($v['estado']=='En Vuelo'?'selected':'') . ">En Vuelo</option>";
        echo "<option value='Retrasado' " . ($v['estado']=='Retrasado'?'selected':'') . ">Retrasado</option>";
        echo "<option value='Finalizado' " . ($v['estado']=='Finalizado'?'selected':'') . ">Finalizado</option>";
        echo "<option value='Cancelado' " . ($v['estado']=='Cancelado'?'selected':'') . ">Cancelado</option>";
        echo "</select>";
        echo "<button type='submit'>Actualizar</button>";
        echo "</form></td>";
        echo "</tr>";
    }
    ?>
  </table>
</div>
