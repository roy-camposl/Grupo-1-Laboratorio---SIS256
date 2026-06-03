<?php
include('conexion.php');

$cantLibros = 0;
$cantUsuarios = 0;
$cantPrestamos = 0;

$resLibros = mysqli_query($con, "SELECT COUNT(*) as total FROM libros");
if ($row = mysqli_fetch_assoc($resLibros)) {
    $cantLibros = $row['total'];
}

$resUsuarios = mysqli_query($con, "SELECT COUNT(*) as total FROM usuarios");
if ($row = mysqli_fetch_assoc($resUsuarios)) {
    $cantUsuarios = $row['total'];
}

$resPrestamos = mysqli_query($con, "SELECT COUNT(*) as total FROM prestamos WHERE estado = 'Activo'");
if ($row = mysqli_fetch_assoc($resPrestamos)) {
    $cantPrestamos = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .caja-info-azul {
            border: 2px solid #004085;
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0px;
        }
        .btn {
            border-radius: 0px;
        }
        .header-simple {
            background-color: #004085;
            padding: 15px;
            margin-bottom: 20px;
        }
        .header-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body class="bg-light">

    <div class="header-simple">
        <div class="container">
            <a class="header-link" href="index.php">Inicio</a>
        </div>
    </div>

    <div class="container">
        <div class="p-3 border mb-4 bg-white">
            <h1 class="h2 text-secondary">Control Biblioteca</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="caja-info-azul">
                    <h4>Catálogo de Libros</h4>
                    <p style="font-size: 35px; color: #004085; margin: 10px 0;"><?php echo $cantLibros; ?></p>
                    <a href="libros/lista.php" class="btn btn-primary w-100" style="background-color: #004085; border-color: #004085;">Ver Libros</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="caja-info-azul">
                    <h4>Registro de Usuarios</h4>
                    <p style="font-size: 35px; color: #004085; margin: 10px 0;"><?php echo $cantUsuarios; ?></p>
                    <a href="usuarios/lista.php" class="btn btn-primary w-100" style="background-color: #004085; border-color: #004085;">Ver Usuarios</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="caja-info-azul">
                    <h4>Préstamos Activos</h4>
                    <p style="font-size: 35px; color: #004085; margin: 10px 0;"><?php echo $cantPrestamos; ?></p>
                    <a href="prestamos/lista.php" class="btn btn-primary w-100" style="background-color: #004085; border-color: #004085;">Ver Préstamos</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>