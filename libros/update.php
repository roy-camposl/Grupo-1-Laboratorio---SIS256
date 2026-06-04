<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrio un error inesperado.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $autor = isset($_POST['autor']) ? trim($_POST['autor']) : '';
    $isbn = isset($_POST['isbn']) ? trim($_POST['isbn']) : null;
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : null;
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    if ($id == 0 || $titulo == '' || $autor == '') {
        $response['mensaje'] = 'Datos insuficientes para modificar.';
        echo json_encode($response);
        exit;
    }

    if ($stock < 0) {
        $response['mensaje'] = 'El stock disponible no puede ser negativo.';
        echo json_encode($response);
        exit;
    }

    try {
        $sql = "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, categoria = ?, stock = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssii", $titulo, $autor, $isbn, $categoria, $stock, $id);

        if ($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Libro modificado correctamente';
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