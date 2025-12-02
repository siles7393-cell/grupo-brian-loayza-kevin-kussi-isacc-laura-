<?php
session_start();
include "conexion.php";
include "functions.php";
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>Vuelos Disponibles</div><div>
    <?php if(isset($_SESSION['pasajero_id'])): ?>
      <a href="mis_reservas.php">Mis Reservas</a>
      <a href="logout_pasajero.php">Cerrar sesión</a>
    <?php else: ?>
      <a href="login_pasajero.php">Login</a>
    <?php endif; ?>
  </div></div>
  <h1>Vuelos Disponibles</h1>
  <table>
    <tr><th>Número</th><th>Origen</th><th>Destino</th><th>Inicio</th><th>Fin</th><th>Asientos</th><th>Acciones</th></tr>
    <?php
    $q = $conexion->query("SELECT v.*, COUNT(r.id) as reservadas, a.capacidad FROM vuelos v 
                           LEFT JOIN reservas r ON v.id = r.vuelo_id AND r.estado='Reservada'
                           LEFT JOIN aeronaves a ON v.aeronave_id = a.id
                           WHERE v.estado='Programado' GROUP BY v.id ORDER BY v.fecha_inicio ASC");
    while($v = $q->fetch_assoc()) {
        $disponibles = $v['capacidad'] - $v['reservadas'];
        echo "<tr>";
        echo "<td>{$v['numero']}</td>";
        echo "<td>{$v['origen']}</td>";
        echo "<td>{$v['destino']}</td>";
        echo "<td>{$v['fecha_inicio']}</td>";
        echo "<td>{$v['fecha_fin']}</td>";
        echo "<td>{$disponibles}/{$v['capacidad']}</td>";
        echo "<td><a class='btn' href='detalle_vuelo_public.php?id={$v['id']}'>Ver Detalles</a></td>";
        echo "</tr>";
    }
    ?>
  </table>
</div>
