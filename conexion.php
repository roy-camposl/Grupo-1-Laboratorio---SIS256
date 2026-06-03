<?php
$con = mysqli_connect("localhost", "root", "", "bd_biblioteca");

if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>