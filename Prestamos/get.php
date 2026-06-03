<?php
include('../conexion.php');
header('Content-Type: application/json');

$res = array('status' => 'error', 'mensaje' => 'No encontrado');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $r = mysqli_query($con, "SELECT p.*, l.titulo, u.nombre FROM prestamos p 
                      JOIN libros l ON p.id_libro = l.id
                      JOIN usuarios u ON p.id_usuario = u.id
                      WHERE p.id=$id");
    $fila = mysqli_fetch_assoc($r);
    
    if ($fila) {
        $res['status'] = 'ok';
        $res['datos'] = $fila;
    }
}

echo json_encode($res);
?>
