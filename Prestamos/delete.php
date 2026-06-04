<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'No se pudo eliminar el registro.');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $check = $con->query("SELECT estado FROM prestamos WHERE id = $id");
        if($row = $check->fetch_assoc()) {
            if($row['estado'] == 'Activo') {
                $response['mensaje'] = 'Accion denegada: No puedes eliminar un prestamo que sigue Activo.';
                echo json_encode($response);
                exit;
            }
        }

        $stmt = $con->prepare("DELETE FROM prestamos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Registro del prestamo eliminado con exito.';
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = 'Error: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>