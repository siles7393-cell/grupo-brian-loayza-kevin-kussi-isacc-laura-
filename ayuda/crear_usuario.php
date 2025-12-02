<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'AdminMaster') { header("Location: index.php"); exit; }
include "conexion.php";
include "style_head.php";

if($_POST){
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $rol = $conexion->real_escape_string($_POST['rol']);
    $empleado_id = !empty($_POST['empleado_id']) ? (int)$_POST['empleado_id'] : null;

    $st = $conexion->prepare("INSERT INTO usuarios (usuario, pass, rol, empleado_id) VALUES (?,?,?,?)");
    $st->bind_param("sssi",$usuario,$pass,$rol,$empleado_id);
    $st->execute();
    echo "<div class='container'><div class='alert alert-success'>Usuario creado correctamente.</div><a href='panel_adminmaster.php'>Volver</a></div>";
    exit;
}
?>
<div class="container">
  <div class="navbar"><div>Crear Usuario</div><div><a href="panel_adminmaster.php">Volver</a></div></div>
  <h2>Crear Usuario</h2>
  <form method="POST">
    <label>Usuario</label><input name="usuario" required>
    <label>Contraseña</label><input type="password" name="pass" required>
    <label>Rol</label>
    <select name="rol" required>
      <option value="AdminMaster">AdminMaster</option>
      <option value="Administrador">Administrador</option>
      <option value="Operaciones">Operaciones</option>
      <option value="Mantenimiento">Mantenimiento</option>
      <option value="Piloto">Piloto</option>
      <option value="Tripulacion">Tripulación</option>
    </select>
    <label>Empleado vinculado (opcional)</label>
    <select name="empleado_id">
      <option value="">Ninguno</option>
      <?php
      $q = $conexion->query("SELECT * FROM empleados ORDER BY nombre");
      while($e = $q->fetch_assoc()){
          echo "<option value='{$e['id']}'>{$e['nombre']} ({$e['rol']})</option>";
      }
      ?>
    </select>
    <button>Crear Usuario</button>
  </form>
</div>
