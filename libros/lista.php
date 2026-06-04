<?php include('../conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark bg-gradient text-dark">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">📚 Sistema Gestion de Biblioteca</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto bg-dark bg-gradient text-white p-2 rounded">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="lista.php">Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="../usuarios/lista.php">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 bg-white mb-4 p-4 rounded shadow-sm">
            <h2 class="display-5 fw-bold" style="color: #343a40;">Catalogo de Libros</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLibro" onclick="limpiarFormulario()">
                + Registrar Nuevo Libro
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Titulo</th>
                            <th class="text-center">Autor</th>
                            <th class="text-center">ISBN</th>
                            <th class="text-center">Categoria</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $con->query("SELECT * FROM libros ORDER BY id DESC");
                        if ($resultado->num_rows > 0) {
                            while($row = $resultado->fetch_assoc()) {
                                echo "<tr id='fila-libro-{$row['id']}'>";
                                echo "<td class='text-center'><strong>".$row['titulo']."</strong></td>";
                                echo "<td class='text-center'><strong>".$row['autor']."</strong></td>";
                                echo "<td class='text-center'><strong>".$row['isbn']."</strong></td>";
                                echo "<td class='text-center'><strong>".$row['categoria']."</strong></td>";
                                echo "<td class='text-center'><span class='badge bg-secondary fs-6'>{$row['stock']}</span></td>";
                                echo "<td class='text-center'>
                                        <button class='btn btn-sm btn-warning me-2' onclick='editarLibro({$row['id']})'>Editar</button>
                                        <button class='btn btn-sm btn-danger' onclick='eliminarLibro({$row['id']})'>Eliminar</button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center p-4 text-muted'>No existen libros registrados en el catalogo.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLibro" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formLibro" onsubmit="guardarLibro(event)">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="modalTitulo">Registrar Libro</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titulo Del Libro *</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Autor Del Libro *</label>
                            <input type="text" id="autor" name="autor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ISBN</label>
                            <input type="text" id="isbn" name="isbn" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Categoria del Libro</label>
                            <input type="text" id="categoria" name="categoria" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Libros en Stock *</label>
                            <input type="number" id="stock" name="stock" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSubmitLibro" class="btn btn-primary">Registrar Libro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Javascript/libros.js"></script>
</body>
</html>