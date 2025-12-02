<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Mantenimiento') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";
?>
<div class="container">
  <div class="navbar"><div>Mantenimiento</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h1>Panel Mantenimiento</h1>

  <h2>Aeronaves</h2>
  <table>
    <tr><th>Modelo</th><th>Matrícula</th><th>Estado</th><th>Horas Vuelo</th><th>Acciones</th></tr>
    <?php
    $q = $conexion->query("SELECT * FROM aeronaves");
    while($a = $q->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$a['modelo']}</td>";
        echo "<td>{$a['matricula']}</td>";
        echo "<td>{$a['estado']}</td>";
        echo "<td>{$a['horas_vuelo']}</td>";
        echo "<td><a class='btn' href='cambiar_estado_aeronave.php?id={$a['id']}'>Cambiar Estado</a></td>";
        echo "</tr>";
    }
    ?>
  </table>
</div>
