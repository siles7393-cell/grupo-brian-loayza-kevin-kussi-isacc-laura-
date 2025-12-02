<?php
session_start();
if(!isset($_SESSION['id'])) { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";

$uid = (int)$_SESSION['id'];
$rol = $_SESSION['rol'];

// Roles de empleados que pueden ver incidencias
$roles_empleados = ['Piloto', 'Tripulacion', 'Mantenimiento', 'Operaciones', 'Administrador'];

if(!in_array($rol, $roles_empleados)) {
    echo "<div class='container'><div class='alert alert-error'>No tienes permiso para acceder a incidencias</div></div>";
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Incidencias</div><div><a href="panel_router.php">Volver</a></div></div>
  <h1>Gestión de Incidencias</h1>
  <div class="flex">
    <a class="btn" href="crear_incidencia.php">+ Crear Incidencia</a>
  </div>

  <h2>Incidencias Reportadas</h2>
  <table>
    <tr><th>ID</th><th>Descripción</th><th>Reportado Por</th><th>Estado</th><th>Fecha</th><th>Acciones</th></tr>
    <?php
    $q = $conexion->query("SELECT i.*, u.usuario FROM incidencias i 
                           LEFT JOIN usuarios u ON i.reportado_por = u.id
                           ORDER BY i.fecha DESC");
    while($inc = $q->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$inc['id']}</td>";
        echo "<td>" . substr($inc['descripcion'], 0, 50) . "...</td>";
        echo "<td>{$inc['usuario']}</td>";
        echo "<td>{$inc['estado']}</td>";
        echo "<td>{$inc['fecha']}</td>";
        echo "<td>";
        echo "<form method='POST' action='incidencias_cambiar.php' style='display:inline'>";
        echo "<input type='hidden' name='id' value='{$inc['id']}'>";
        echo "<select name='estado'>";
        echo "<option value='Abierto' " . ($inc['estado']=='Abierto'?'selected':'') . ">Abierto</option>";
        echo "<option value='En Proceso' " . ($inc['estado']=='En Proceso'?'selected':'') . ">En Proceso</option>";
        echo "<option value='Cerrado' " . ($inc['estado']=='Cerrado'?'selected':'') . ">Cerrado</option>";
        echo "</select>";
        echo "<button type='submit'>Cambiar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
  </table>
</div>
