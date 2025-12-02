<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";
$minDate = date("Y-m-d\TH:i", strtotime('+1 day'));
?>
<div class="container">
  <div class="navbar"><div>Crear Vuelo</div><div><a href="panel_administrador.php">Volver</a></div></div>

  <form action="crear_vuelo_guardar.php" method="POST" onsubmit="return validarFechas()">
    <label>Número de Vuelo</label><input name="numero" required>
    <label>Origen (Ciudad, País)</label>
    <input name="origen" list="lista_destinos" required>
    <label>Destino (Ciudad, País)</label>
    <input name="destino" list="lista_destinos" required>

    <datalist id="lista_destinos">
      <?php $d = $conexion->query("SELECT pais, ciudad FROM destinos ORDER BY pais, ciudad");
      while($r = $d->fetch_assoc()){ $label = $r['ciudad'] . ', ' . $r['pais']; echo "<option value='{$label}'></option>"; } ?>
    </datalist>

    <label>Fecha inicio</label>
    <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" min="<?php echo $minDate; ?>" required>

    <label>Fecha fin</label>
    <input type="datetime-local" name="fecha_fin" id="fecha_fin" min="<?php echo $minDate; ?>" required>

    <label>Aeronave (solo operativa)</label>
    <select name="aeronave_id" required>
      <?php $ar = $conexion->query("SELECT * FROM aeronaves WHERE estado='Operativa'");
      while($a=$ar->fetch_assoc()){ echo "<option value='{$a['id']}' data-cap='{$a['capacidad']}'>{$a['modelo']} - {$a['matricula']} (cap: {$a['capacidad']})</option>"; } ?>
    </select>

    <label>Piloto</label>
    <select name="piloto_id" required>
      <option value="">-- elegir --</option>
      <?php $p = $conexion->query("SELECT * FROM empleados WHERE rol='Piloto' AND disponible=1");
      while($r = $p->fetch_assoc()) echo "<option value='{$r['id']}'>{$r['nombre']}</option>"; ?>
    </select>

    <label>Tripulación (Ctrl+click para varios)</label>
    <select name="tripulacion_ids[]" multiple size="6" required>
      <?php $t = $conexion->query("SELECT * FROM empleados WHERE rol='Tripulacion' AND disponible=1");
      while($r = $t->fetch_assoc()) echo "<option value='{$r['id']}'>{$r['nombre']}</option>"; ?>
    </select>

    <label>Duración estimada (horas)</label>
    <input type="number" name="duracion_horas" min="1" value="2" required>

    <button>Crear Vuelo</button>
  </form>
</div>

<script>
function validarFechas(){
  const inicio = document.getElementById('fecha_inicio').value;
  const fin = document.getElementById('fecha_fin').value;
  if(!inicio || !fin) return false;
  if(inicio >= fin){ alert('Fecha inicio debe ser anterior'); return false; }
  return true;
}
</script>
