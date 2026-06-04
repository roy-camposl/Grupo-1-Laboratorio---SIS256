<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrio un error inesperado.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_libro = intval($_POST['id_libro']);
    $id_usuario = intval($_POST['id_usuario']);
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_devolucion = $_POST['fecha_devolucion'];
    $observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '';

    if ($id_libro == 0 || $id_usuario == 0 || empty($fecha_prestamo) || empty($fecha_devolucion)) {
        $response['mensaje'] = 'Todos los campos obligatorios (*) deben ser rellenados.';
        echo json_encode($response);
        exit;
    }

    $check = $con->query("SELECT stock FROM libros WHERE id = $id_libro");
    if($row = $check->fetch_assoc()) {
        if($row['stock'] <= 0) {
            $response['mensaje'] = 'El libro seleccionado ya no dispone de stock fisico para prestamo.';
            echo json_encode($response);
            exit;
        }
    }

    try {
        $con->query("UPDATE libros SET stock = stock - 1 WHERE id = $id_libro");

        $sql = "INSERT INTO prestamos (id_libro, id_usuario, fecha_prestamo, fecha_devolucion, observaciones, estado) VALUES (?, ?, ?, ?, ?, 'Activo')";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iisss", $id_libro, $id_usuario, $fecha_prestamo, $fecha_devolucion, $observaciones);

        if ($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Prestamo guardado exitosamente. Stock del libro actualizado.';
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = 'Error al procesar: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>