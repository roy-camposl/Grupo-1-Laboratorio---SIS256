<?php include('../conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros</title>
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
            <h2>Catálogo de Libros</h2>
            <button type="button" class="btn btn-primary" style="background-color: #004085; border-color: #004085;" data-bs-toggle="modal" data-bs-target="#modalLibro" onclick="limpiarFormulario()">
                Registrar Nuevo Libro
            </button>
        </div>

        <table class="table table-bordered bg-white">
            <thead style="background-color: #004085; color: white;">
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = mysqli_query($con, "SELECT * FROM libros ORDER BY id DESC");
                if (mysqli_num_rows($resultado) > 0) {
                    while($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr id='fila-libro-".$row['id']."'>";
                        echo "<td><strong>".$row['titulo']."</strong></td>";
                        echo "<td>".$row['autor']."</td>";
                        echo "<td>".$row['isbn']."</td>";
                        echo "<td>".$row['categoria']."</td>";
                        echo "<td>".$row['stock']."</td>";
                        echo "<td class='text-center'>
                                <button class='btn btn-sm btn-primary me-2' onclick='editarLibro(".$row['id'].")'>Editar</button>
                                <button class='btn btn-sm btn-danger' onclick='eliminarLibro(".$row['id'].")'>Eliminar</button>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center p-4 text-muted'>lista vacia</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalLibro" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formLibro" onsubmit="guardarLibro(event)">
                    <div class="modal-header text-white" style="background-color: #004085;">
                        <h5 class="modal-title" id="modalTitulo">Registrar Libro</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label class="form-label">Título *</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Autor *</label>
                            <input type="text" id="autor" name="autor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" id="isbn" name="isbn" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <input type="text" id="categoria" name="categoria" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Inicial *</label>
                            <input type="number" id="stock" name="stock" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #004085; border-color: #004085;">Guardar Libro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JavaScript/libros.js"></script>
</body>
</html>