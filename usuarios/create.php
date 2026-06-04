<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrio un error inesperado.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $carnet = isset($_POST['carnet']) ? trim($_POST['carnet']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : null;

    if ($nombre == '' || $carnet == '') {
        $response['mensaje'] = 'El nombre completo y el carnet son obligatorios.';
        echo json_encode($response);
        exit;
    }

    try {
        $sql = "INSERT INTO usuarios (nombre, carnet, telefono, correo) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $carnet, $telefono, $correo);

        if ($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Usuario registrado correctamente';
        } else {
            $response['mensaje'] = 'Error al insertar: ' . $stmt->error;
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = 'Error de base de datos (Carnet duplicado u otro): ' . $e->getMessage();
    }
}
echo json_encode($response);
?>