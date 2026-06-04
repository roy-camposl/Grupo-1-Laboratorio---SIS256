<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Registro no encontrado.');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $sql = "SELECT * FROM libros WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $response['status'] = 'ok';
            $response['datos'] = $row;
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = $e->getMessage();
    }
}
echo json_encode($response);
?>