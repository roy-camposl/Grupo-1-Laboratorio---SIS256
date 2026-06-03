<?php include('../conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
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
            <h2>Lista de Usuarios</h2>
            <button type="button" class="btn btn-primary" style="background-color: #004085; border-color: #004085;" data-bs-toggle="modal" data-bs-target="#modalUsuario" onclick="limpiarFormulario()">
                Registrar Nuevo Usuario
            </button>
        </div>

        <table class="table table-bordered bg-white">
            <thead style="background-color: #004085; color: white;">
                <tr>
                    <th>Nombre Completo</th>
                    <th>Carnet Identidad</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = mysqli_query($con, "SELECT * FROM usuarios ORDER BY id DESC");
                if (mysqli_num_rows($resultado) > 0) {
                    while($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr id='fila-usuario-".$row['id']."'>";
                        echo "<td><strong>".$row['nombre']."</strong></td>";
                        echo "<td>".$row['carnet']."</td>";
                        echo "<td>".$row['telefono']."</td>";
                        echo "<td>".$row['correo']."</td>";
                        echo "<td class='text-center'>
                                <button class='btn btn-sm btn-primary me-2' onclick='editarUsuario(".$row['id'].")'>Editar</button>
                                <button class='btn btn-sm btn-danger' onclick='eliminarUsuario(".$row['id'].")'>Eliminar</button>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center p-4 text-muted'>No existen usuarios registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formUsuario" onsubmit="guardarUsuario(event)">
                    <div class="modal-header text-white" style="background-color: #004085;">
                        <h5 class="modal-title" id="modalTitulo">Registrar Usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label class="form-label">Nombre Completo *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Carnet de Identidad *</label>
                            <input type="text" id="carnet" name="carnet" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" id="correo" name="correo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #004085; border-color: #004085;">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JavaScript/usuarios.js"></script>
</body>
</html>