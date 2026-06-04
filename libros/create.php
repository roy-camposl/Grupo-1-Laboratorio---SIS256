<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrio un error inesperado.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $autor = isset($_POST['autor']) ? trim($_POST['autor']) : '';
    $isbn = isset($_POST['isbn']) ? trim($_POST['isbn']) : null;
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : null;
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    if ($titulo == '' || $autor == '') {
        $response['mensaje'] = 'El título y el autor son campos obligatorios.';
        echo json_encode($response);
        exit;
    }

    
    if ($stock < 0) {
        $response['mensaje'] = 'El stock disponible no puede ser negativo.';
        echo json_encode($response);
        exit;
    }

    try {
        $sql = "INSERT INTO libros (titulo, autor, isbn, categoria, stock) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $titulo, $autor, $isbn, $categoria, $stock);

        if ($stmt->execute()) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Libro registrado correctamente';
        } else {
            $response['mensaje'] = 'Error al insertar: ' . $stmt->error;
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['mensaje'] = 'Error en base de datos: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>