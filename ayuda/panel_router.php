<?php
session_start();
if(!isset($_SESSION['id'])) { header("Location: index.php"); exit; }
$rol = $_SESSION['rol'];
switch($rol) {
    case 'AdminMaster': header("Location: panel_adminmaster.php"); break;
    case 'Administrador': header("Location: panel_administrador.php"); break;
    case 'Operaciones': header("Location: panel_operaciones.php"); break;
    case 'Mantenimiento': header("Location: panel_mantenimiento.php"); break;
    case 'Piloto': header("Location: panel_piloto.php"); break;
    case 'Tripulacion': header("Location: panel_tripulacion.php"); break;
    default: echo "Rol no reconocido"; break;
}
exit;
