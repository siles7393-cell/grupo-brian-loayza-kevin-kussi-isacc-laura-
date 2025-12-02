<?php
session_start();
include "conexion.php";
include "functions.php";
include "style_head.php";
$id = (int)$_GET['id'];
$st = $conexion->prepare("SELECT v.*, a.matricula, a.capacidad FROM vuelos v LEFT JOIN aeronaves a ON v.aeronave_id = a.id WHERE v.id = ? LIMIT 1");
$st->bind_param("i",$id); $st->execute(); $vu = $st->get_result()->fetch_assoc();
if(!$vu) { echo "Vuelo no encontrado"; exit; }
$reserved = contar_reservas_vuelo($conexion, $id);
$available = $vu['capacidad'] - $reserved;
?>
<div class="container">
  <div class="navbar"><div>Vuelo <?=$vu['numero']?></div><div><a href="ver_vuelos_public.php">Volver</a></div></div>
  <h2><?=$vu['origen']?> → <?=$vu['destino']?></h2>
  <p>Inicio: <?=$vu['fecha_inicio']?> — Fin: <?=$vu['fecha_fin']?></p>
  <p>Aeronave: <?=$vu['matricula']?> (cap <?=$vu['capacidad']?>) — Asientos libres: <?=$available?></p>

  <?php if(isset($_SESSION['pasajero_id'])): ?>
    <?php if($available>0): ?>
      <form action="reservar_vuelo.php" method="POST">
        <input type="hidden" name="vuelo_id" value="<?=$id?>">
        <label>Asiento (opcional)</label><input name="asiento" placeholder="12A">
        <button>Reservar</button>
      </form>
    <?php else: ?>
      <div class="alert alert-error">No quedan asientos</div>
    <?php endif; ?>
  <?php else: ?>
    <div class="alert alert-error">Debes <a href="login_pasajero.php">iniciar sesión</a> para reservar.</div>
  <?php endif; ?>
</div>
