<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Piloto'){ header("Location: index.php"); exit; }
include "conexion.php"; include "functions.php"; include "style_head.php";
$uid = (int)$_SESSION['id'];
$empleado_id = (int)$conexion->query("SELECT empleado_id FROM usuarios WHERE id = $uid")->fetch_assoc()['empleado_id'];

$q = $conexion->prepare("SELECT * FROM vuelos WHERE piloto_id = ? ORDER BY fecha_inicio ASC");
$q->bind_param("i",$empleado_id); $q->execute(); $res = $q->get_result();
?>
<div class="container"><div class="navbar"><div>Piloto</div><div><a href="logout.php">Cerrar sesión</a></div></div>
  <h2>Mis vuelos</h2>
  <div class="flex">
    <a class="btn" href="incidencias.php">Incidencias</a>
    <a class="btn" href="chat.php">Chat</a>
  </div>
  <?php while($v=$res->fetch_assoc()): ?>
    <div class="card">
      <b><?=$v['numero']?></b> <?=$v['origen']?>→<?=$v['destino']?><br>
      Inicio: <?=$v['fecha_inicio']?> Fin: <?=$v['fecha_fin']?> Estado: <?=$v['estado']?>
      <div class="flex">
        <?php if($v['estado']=='Programado'): ?>
          <form method="POST" action="piloto_acciones.php"><input type="hidden" name="vuelo_id" value="<?=$v['id']?>">
            <button name="accion" value="iniciar">Marcar En Vuelo</button>
          </form>
        <?php elseif($v['estado']=='En Vuelo'): ?>
          <form method="POST" action="piloto_acciones.php"><input type="hidden" name="vuelo_id" value="<?=$v['id']?>">
            <button name="accion" value="finalizar">Finalizar</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>
