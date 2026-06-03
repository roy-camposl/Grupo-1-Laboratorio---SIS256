<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Registro no encontrado.');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $resultado = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($resultado)) {
        $response['status'] = 'ok';
        $response['datos'] = $row;
    }
}
echo json_encode($response);
?>