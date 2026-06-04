<?php
include('conexion.php');

$cantLibros = 0;
$cantUsuarios = 0;
$cantPrestamos = 0;

    $resLibros = $con->query("SELECT COUNT(*) as total FROM libros");

        if($row = $resLibros->fetch_assoc()) $cantLibros = $row['total'];

    $resUsuarios = $con->query("SELECT COUNT(*) as total FROM usuarios");

        if($row = $resUsuarios->fetch_assoc()) $cantUsuarios = $row['total'];

    $resPrestamos = $con->query("SELECT COUNT(*) as total FROM prestamos WHERE estado='Activo'");
    
        if($row = $resPrestamos->fetch_assoc()) $cantPrestamos = $row['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestion de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark bg-gradient text-white">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">📚 Sistema Gestion de Biblioteca</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto bg-dark bg-gradient text-white p-2 rounded">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="libros/lista.php">Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios/lista.php">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="prestamos/lista.php">Prestamos</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="p-4 shadow-sm rounded bg-white mb-5">
            <h1 class="display-5 fw-bold" style="color: #343a40; text-align: center;">Panel de Control Sistema Biblioteca</h1>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <h3 class="card-title h5">Catalogo de Libros</h3>
                            <p class="display-4 fw-bold my-2"><?php echo $cantLibros; ?></p>
                        </div>
                        <a href="libros/lista.php" class="btn btn-light text-primary fw-bold mt-3 align-self-start">Libros Registrados →</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <h3 class="card-title h5">Registro de Usuarios</h3>
                            <p class="display-4 fw-bold my-2"><?php echo $cantUsuarios; ?></p>
                        </div>
                        <a href="usuarios/lista.php" class="btn btn-light text-success fw-bold mt-3 align-self-start">Usuarios Registrados →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-warning text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <h3 class="card-title h5">Prestamos Activos</h3>
                            <p class="display-4 fw-bold my-2"><?php echo $cantPrestamos; ?></p>
                        </div>
                        <a href="prestamos/lista.php" class="btn btn-light text-warning fw-bold mt-3 align-self-start">Control de Libros Prestados →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <footer class="text-center py-4 mt-5 border-top bg-dark bg-gradient text-white">
            <div class="footer-container">
                <p>© 2026 Sistema de Gestion de Biblioteca Desarrollo Web SIS - 256</p>
            </div>
        </footer>
</body>
</html>