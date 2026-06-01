<?php
header("Content-Type: application/json");

$conexion = new mysqli("localhost", "root", "", "bd_biblioteca");
if ($conexion->connect_error) {
    die(json_encode([
        "success" => false,
        "mensaje" => "Error de conexión"
    ]));
}

$datos = json_decode(file_get_contents("php://input"), true);

$nombre   = trim($datos["nombre"]);
$carnet   = trim($datos["carnet"]);
$telefono = trim($datos["telefono"]);
$correo   = trim($datos["correo"]);

if (empty($nombre) || empty($carnet)) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Nombre y carnet son obligatorios"
    ]);
    exit;
}

$sql = "INSERT INTO usuarios(nombre, carnet, telefono, correo)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $nombre, $carnet, $telefono, $correo);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "mensaje" => "Usuario registrado correctamente"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "mensaje" => "Error al registrar usuario: " . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();
?>