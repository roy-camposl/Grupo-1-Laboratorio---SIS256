<?php
include('../conexion.php');
header('Content-Type: application/json');

$res = array('status' => 'error', 'mensaje' => 'Error');

if ($_POST) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $est = isset($_POST['estado']) ? $_POST['estado'] : '';
    
    if ($id && $est) {
        $r = mysqli_query($con, "SELECT id_libro, estado FROM prestamos WHERE id=$id");
        $fila = mysqli_fetch_assoc($r);
        
        if ($fila) {
            if ($est == 'Devuelto' && $fila['estado'] == 'Activo') {
                mysqli_query($con, "UPDATE libros SET stock=stock+1 WHERE id={$fila['id_libro']}");
            }
            mysqli_query($con, "UPDATE prestamos SET estado='$est' WHERE id=$id");
            $res['status'] = 'ok';
            $res['mensaje'] = 'Actualizado';
        }
    }
}

echo json_encode($res);
?>
