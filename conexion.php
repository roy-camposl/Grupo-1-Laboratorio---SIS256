<?php
$server = "localhost:3307"; $user = "root"; $pass = ""; $db = "bd_biblioteca";

$con = new mysqli($server, $user, $pass, $db);

if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}
?>