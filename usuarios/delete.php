<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'No se pudo eliminar.');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM usuarios WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        $response['status'] = 'ok';
        $response['mensaje'] = 'Usuario eliminado correctamente';
    } else {
        $response['mensaje'] = 'No se puede eliminar: ' . mysqli_error($con);
    }
}
echo json_encode($response);
?>