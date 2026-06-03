<?php
include('../conexion.php');
header('Content-Type: application/json');

$response = array('status' => 'error', 'mensaje' => 'Ocurrió un error.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    if ($id == 0 || $titulo == '' || $autor == '') {
        $response['mensaje'] = 'Datos insuficientes para modificar.';
    } elseif ($stock < 0) {
        $response['mensaje'] = 'El stock disponible no puede ser negativo.';
    } else {
        $sql = "UPDATE libros SET titulo = '$titulo', autor = '$autor', isbn = '$isbn', categoria = '$categoria', stock = $stock WHERE id = $id";
        if (mysqli_query($con, $sql)) {
            $response['status'] = 'ok';
            $response['mensaje'] = 'Libro modificado correctamente';
        } else {
            $response['mensaje'] = 'Error al modificar: ' . mysqli_error($con);
        }
    }
}
echo json_encode($response);
?>