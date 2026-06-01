<?php
include("conexion.php");

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$isbn = $_POST['isbn'];
$categoria = $_POST['categoria'];
$stock = $_POST['stock'];

$sql = "INSERT INTO libros (titulo, autor, isbn, categoria, stock) 
        VALUES ('$titulo', '$autor', '$isbn', '$categoria', $stock)";

if (mysqli_query($conexion, $sql)) {
    echo json_encode([
        "status" => "ok",
        "mensaje" => "Libro registrado con éxito"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error al registrar: " . mysqli_error($conexion)
    ]);
}
?>