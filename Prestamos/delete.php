<?php
include('../conexion.php');
header('Content-Type: application/json');

$res = array('status' => 'error', 'mensaje' => 'Error');

if ($_POST) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    if ($id) {
        $r = mysqli_query($con, "SELECT estado FROM prestamos WHERE id=$id");
        $fila = mysqli_fetch_assoc($r);
        
        if ($fila && $fila['estado'] != 'Activo') {
            mysqli_query($con, "DELETE FROM prestamos WHERE id=$id");
            $res['status'] = 'ok';
            $res['mensaje'] = 'Eliminado';
        } else {
            $res['mensaje'] = 'No se puede eliminar préstamo activo';
        }
    }
}

echo json_encode($res);
?>
