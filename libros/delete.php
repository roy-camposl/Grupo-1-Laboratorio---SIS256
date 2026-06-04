<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'No se pudo eliminar.');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $sql = "DELETE FROM libros WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Libro eliminado correctamente';
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = 'No se puede eliminar: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>