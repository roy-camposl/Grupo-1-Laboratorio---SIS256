<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'No se pudo actualizar el estado.');

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = intval($_GET['id']);
    $nuevo_estado = $_GET['estado'];

    try {
        $info = $con->query("SELECT id_libro, estado FROM prestamos WHERE id = $id");
        if($row = $info->fetch_assoc()) {
            if($row['estado'] == 'Activo') {
                
                if($nuevo_estado == 'Devuelto') {
                    $id_libro = $row['id_libro'];
                    $con->query("UPDATE libros SET stock = stock + 1 WHERE id = $id_libro");
                }
                
                $stmt = $con->prepare("UPDATE prestamos SET estado = ? WHERE id = ?");
                $stmt->bind_param("si", $nuevo_estado, $id);
                if($stmt->execute()) {
                    $response['status'] = 'ok';
                    $response['mensaje'] = 'Estado actualizado y stock sincronizado de forma correcta.';
                }
                $stmt->close();
            } else {
                $response['mensaje'] = 'Este prestamo ya no se encuentra Activo.';
            }
        }
    } catch (Exception $e) {
        $response['mensaje'] = 'Error: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>