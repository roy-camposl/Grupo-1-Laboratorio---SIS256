<?php include('../conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control, .form-select, .btn, .modal-content, .badge {
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
        tr.prestamo-vencido td {
            background-color: #ffcccc;
            color: #cc0000;
        }
    </style>
</head>
<body class="bg-light">

    <div class="header-simple">
        <div class="container">
            <a class="header-link" href="../index.php">Inicio</a>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h2>Gestión de Préstamos</h2>
            <button type="button" class="btn btn-primary" style="background-color: #004085; border-color: #004085;" data-bs-toggle="modal" data-bs-target="#modalPrestamo">
                Nuevo Préstamo
            </button>
        </div>

        <div class="border p-3 bg-white mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Filtrar por Libro</label>
                    <select class="form-select" id="filtroLibro" onchange="filtrarPrestamos()">
                        <option value="">Todos</option>
                        <?php
                        $resLibros = mysqli_query($con, "SELECT id, titulo FROM libros ORDER BY titulo");
                        while ($row = mysqli_fetch_assoc($resLibros)) {
                            echo "<option value='".$row['id']."'>".$row['titulo']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filtrar por Usuario</label>
                    <select class="form-select" id="filtroUsuario" onchange="filtrarPrestamos()">
                        <option value="">Todos</option>
                        <?php
                        $resUsuarios = mysqli_query($con, "SELECT id, nombre FROM usuarios ORDER BY nombre");
                        while ($row = mysqli_fetch_assoc($resUsuarios)) {
                            echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filtrar por Estado</label>
                    <select class="form-select" id="filtroEstado" onchange="filtrarPrestamos()">
                        <option value="">Todos los estados</option>
                        <option value="Activo">Activo</option>
                        <option value="Devuelto">Devuelto</option>
                        <option value="Vencido">Vencido</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table table-bordered bg-white">
            <thead style="background-color: #004085; color: white;">
                <tr>
                    <th>Libro</th>
                    <th>Usuario</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaPrestamos">
                <!-- Se cargará con JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal registrar préstamo -->
    <div class="modal fade" id="modalPrestamo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formPrestamo" onsubmit="guardarPrestamo(event)">
                    <div class="modal-header text-white" style="background-color: #004085;">
                        <h5 class="modal-title">Nuevo Préstamo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_libro" class="form-label">Libro</label>
                            <select class="form-select" id="id_libro" required>
                                <option value="">Seleccione un libro</option>
                                <?php
                                $resLibros = mysqli_query($con, "SELECT id, titulo, stock FROM libros WHERE stock > 0 ORDER BY titulo");
                                while ($row = mysqli_fetch_assoc($resLibros)) {
                                    echo "<option value='".$row['id']."'>".$row['titulo']." (Stock: ".$row['stock'].")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_usuario" class="form-label">Usuario</label>
                            <select class="form-select" id="id_usuario" required>
                                <option value="">Seleccione un usuario</option>
                                <?php
                                $resUsuarios = mysqli_query($con, "SELECT id, nombre FROM usuarios ORDER BY nombre");
                                while ($row = mysqli_fetch_assoc($resUsuarios)) {
                                    echo "<option value='".$row['id']."'>".$row['nombre']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_prestamo" class="form-label">Fecha de Préstamo</label>
                            <input type="date" class="form-control" id="fecha_prestamo" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_devolucion" class="form-label">Fecha de Devolución Esperada</label>
                            <input type="date" class="form-control" id="fecha_devolucion" required>
                        </div>
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                            <textarea class="form-control" id="observaciones" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #004085; border-color: #004085;">Registrar Préstamo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JavaScript/prestamos.js"></script>
    <script>
        cargarPrestamos();
        setInterval(cargarPrestamos, 30000);
    </script>
</body>
</html>
