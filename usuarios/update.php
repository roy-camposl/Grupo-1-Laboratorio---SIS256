<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrio un error inesperado.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $carnet = isset($_POST['carnet']) ? trim($_POST['carnet']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : null;

    if ($id == 0 || $nombre == '' || $carnet == '') {
        $response['mensaje'] = 'Datos insuficientes para modificar.';
        echo json_encode($response);
        exit;
    }

    try {
        $sql = "UPDATE usuarios SET nombre = ?, carnet = ?, telefono = ?, correo = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $carnet, $telefono, $correo, $id);

        if ($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Usuario modificado correctamente';
        } else {
            $response['mensaje'] = 'Error al modificar: ' . $stmt->error;
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = 'Error en base de datos: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>