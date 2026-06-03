<?php
include('../conexion.php');
header('Content-Type: application/json');

$res = array('status' => 'error', 'mensaje' => 'Error');

if ($_POST) {
    $lib = isset($_POST['id_libro']) ? intval($_POST['id_libro']) : 0;
    $usr = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
    $fpres = isset($_POST['fecha_prestamo']) ? $_POST['fecha_prestamo'] : '';
    $fdev = isset($_POST['fecha_devolucion']) ? $_POST['fecha_devolucion'] : '';
    $obs = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

    if ($lib && $usr && $fpres && $fdev) {
        $r = mysqli_query($con, "SELECT stock FROM libros WHERE id=$lib");
        $fila = mysqli_fetch_assoc($r);
        
        if ($fila && $fila['stock'] > 0) {
            mysqli_query($con, "INSERT INTO prestamos(id_libro,id_usuario,fecha_prestamo,fecha_devolucion,observaciones,estado) VALUES($lib,$usr,'$fpres','$fdev','$obs','Activo')");
            mysqli_query($con, "UPDATE libros SET stock=stock-1 WHERE id=$lib");
            $res['status'] = 'ok';
            $res['mensaje'] = 'Registrado correctamente';
        } else {
            $res['mensaje'] = 'Sin stock disponible';
        }
    } else {
        $res['mensaje'] = 'Campos incompletos';
    }
}

echo json_encode($res);
?>
