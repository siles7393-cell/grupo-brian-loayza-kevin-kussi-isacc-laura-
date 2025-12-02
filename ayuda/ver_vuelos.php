<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit;
}
include "conexion.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver vuelos</title>
</head>
<body>

<h1>Lista de vuelos</h1>

<table border="1">
<tr>
    <th>Número</th>
    <th>Origen</th>
    <th>Destino</th>
    <th>Fecha</th>
    <th>Aeronave</th>
    <th>Piloto</th>
    <th>Tripulación</th>
    <th>Estado</th>
</tr>

<?php
$sql = "
SELECT v.*, 
a.matricula,
p.nombre AS piloto,
t.nombre AS tripulacion
FROM vuelos v
LEFT JOIN aeronaves a ON v.aeronave_id = a.id
LEFT JOIN empleados p ON v.piloto_id = p.id
LEFT JOIN empleados t ON v.tripulacion_id = t.id
ORDER BY fecha ASC
";

$res = $conn->query($sql);

while ($row = $res->fetch_assoc()):
?>
<tr>
    <td><?= $row['numero'] ?></td>
    <td><?= $row['origen'] ?></td>
    <td><?= $row['destino'] ?></td>
    <td><?= $row['fecha'] ?></td>
    <td><?= $row['matricula'] ?></td>
    <td><?= $row['piloto'] ?></td>
    <td><?= $row['tripulacion'] ?></td>
    <td><?= $row['estado'] ?></td>
</tr>
<?php endwhile; ?>

</table>

<br><a href="javascript:history.back()">⬅ Volver</a>

</body>
</html>
