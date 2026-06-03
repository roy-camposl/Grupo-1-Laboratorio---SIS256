<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrió un error.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $carnet = isset($_POST['carnet']) ? $_POST['carnet'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';

    if ($id == 0 || $nombre == '' || $carnet == '') {
        $response['mensaje'] = 'Datos insuficientes para modificar.';
    } else {
        $sql = "UPDATE usuarios SET nombre = '$nombre', carnet = '$carnet', telefono = '$telefono', correo = '$correo' WHERE id = $id";
        if (mysqli_query($con, $sql)) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Usuario modificado correctamente';
        } else {
            $response['mensaje'] = 'Error al modificar: ' . mysqli_error($con);
        }
    }
}
echo json_encode($response);
?>