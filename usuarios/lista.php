<?php include('../conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark bg-gradient text-dark">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">📚 Sistema Gestion de Biblioteca</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto bg-dark bg-gradient text-white p-2 rounded">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="../libros/lista.php">Libros</a></li>
                    <li class="nav-item"><a class="nav-link active" href="lista.php">Usuarios</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 bg-white mb-4 p-4 rounded shadow-sm">
            <h2 class="display-5 fw-bold" style="color: #343a40;">Lista de Usuarios</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUsuario" onclick="limpiarFormulario()">
                + Registrar Nuevo Usuario
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Nombre Completo</th>
                            <th class="text-center">Carnet Identidad</th>
                            <th class="text-center">Telefono</th>
                            <th class="text-center">Correo Electronico</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $con->query("SELECT * FROM usuarios ORDER BY id DESC");
                        if ($resultado->num_rows > 0) {
                            while($row = $resultado->fetch_assoc()) {
                                echo "<tr id='fila-usuario-{$row['id']}'>";
                                echo "<td class='text-center'><strong>".$row['nombre']."</strong></td>";
                                echo "<td class='text-center'><strong>".$row['carnet']."</strong></td>";
                                echo "<td class='text-center'><strong>".$row['telefono']."</strong></td>";
                                echo "<td class='text-center'><strong>".$row['correo']."</strong></td>";
                                echo "<td class='text-center'>
                                        <button class='btn btn-sm btn-warning me-2' onclick='editarUsuario({$row['id']})'>Editar</button>
                                        <button class='btn btn-sm btn-danger' onclick='eliminarUsuario({$row['id']})'>Eliminar</button>
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
        </div>
    </div>

    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formUsuario" onsubmit="guardarUsuario(event)">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="modalTitulo">Registrar Usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Carnet de Identidad *</label>
                            <input type="text" id="carnet" name="carnet" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Telefono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electronico</label>
                            <input type="email" id="correo" name="correo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSubmitUsuario" class="btn btn-success">Registrar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Javascript/usuarios.js"></script>
</body>
</html>