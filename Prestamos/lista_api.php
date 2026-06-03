<?php
include('../conexion.php');
header('Content-Type: application/json');

$sql = "SELECT p.id, p.fecha_prestamo, p.fecha_devolucion, p.estado, l.titulo, u.nombre 
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        JOIN usuarios u ON p.id_usuario = u.id
        WHERE 1=1";

if (isset($_GET['id_libro']) && $_GET['id_libro'] != '') {
    $lib = intval($_GET['id_libro']);
    $sql .= " AND p.id_libro = $lib";
}

if (isset($_GET['id_usuario']) && $_GET['id_usuario'] != '') {
    $usr = intval($_GET['id_usuario']);
    $sql .= " AND p.id_usuario = $usr";
}

if (isset($_GET['estado']) && $_GET['estado'] != '') {
    $est = mysqli_real_escape_string($con, $_GET['estado']);
    $sql .= " AND p.estado = '$est'";
}

$sql .= " ORDER BY p.fecha_devolucion DESC";

$r = mysqli_query($con, $sql);
$lista = array();

while ($fila = mysqli_fetch_assoc($r)) {
    $lista[] = $fila;
}

echo json_encode(array('status' => 'ok', 'prestamos' => $lista));
?>
