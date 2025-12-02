<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>Ver Reservas</div><div><a href="panel_administrador.php">Volver</a></div></div>
  <h1>Todas las Reservas</h1>
  <table>
    <tr><th>ID</th><th>Vuelo</th><th>Pasajero</th><th>Asiento</th><th>Estado</th><th>Fecha</th></tr>
    <?php
    $q = $conexion->query("SELECT r.*, v.numero, p.nombre FROM reservas r 
                           JOIN vuelos v ON r.vuelo_id = v.id 
                           JOIN pasajeros p ON r.pasajero_id = p.id 
                           ORDER BY r.fecha_reserva DESC");
    while($r = $q->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$r['id']}</td>";
        echo "<td>{$r['numero']}</td>";
        echo "<td>{$r['nombre']}</td>";
        echo "<td>{$r['asiento']}</td>";
        echo "<td>{$r['estado']}</td>";
        echo "<td>{$r['fecha_reserva']}</td>";
        echo "</tr>";
    }
    ?>
  </table>
</div>
