<?php
header("Content-Type: application/json");
$conexion = new mysqli("localhost", "root", "", "db_biblioteca");
if ($conexion->connect_error) {
    die(json_encode([
        "success" => false,
        "mensaje" => "Error de conexión"
    ]));
}  
?>