<?php
include('../conexion.php');
$fecha_actual = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Prestamos</title>
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
                    <li class="nav-item"><a class="nav-link" href="../usuarios/lista.php">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link active" href="lista.php">Prestamos</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 bg-white mb-4 p-4 rounded shadow-sm">
            <h2 class="display-5 fw-bold" style="color: #343a40;">Control de Prestamos y Devoluciones</h2>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPrestamo" onclick="limpiarFormulario()">
                + Registrar Prestamo
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <input type="text" id="filtroBusqueda" class="form-control" placeholder="Buscar por libro o usuario..." onkeyup="filtrarPrestamos()">
            </div>
            <div class="col-md-4">
                <select id="filtroEstado" class="form-select" onchange="filtrarPrestamos()">
                    <option value="Todos">Todos los Estados</option>
                    <option value="Activo">Activos</option>
                    <option value="Devuelto">Devueltos</option>
                    <option value="Vencido">Vencidos</option>
                </select>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-center mb-0" id="tablaPrestamos">
                    <thead class="table-dark ">
                        <tr>
                            <th class="text-center">Libro</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">F. Prestamo</th>
                            <th class="text-center">F. Devolucion</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Observaciones</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.*, l.titulo AS libro, u.nombre AS usuario
                                FROM prestamos p
                                JOIN libros l ON p.id_libro = l.id
                                JOIN usuarios u ON p.id_usuario = u.id
                                ORDER BY p.id DESC";
                        
                        $resultado = $con->query($sql);
                        if ($resultado->num_rows > 0) {
                            while($row = $resultado->fetch_assoc()) {
                                
                                $claseFila = '';
                                if ($row['estado'] == 'Activo' && $row['fecha_devolucion'] < $fecha_actual) {
                                    $claseFila = 'prestamo-vencido';
                                }

                                echo "<tr id='fila-prestamo-{$row['id']}' class='{$claseFila}' data-libro='{$row['libro']}' data-usuario='{$row['usuario']}' data-estado='{$row['estado']}'>";
                                echo "<td class='text-center'><strong>{$row['libro']}</strong></td>";
                                echo "<td class='text-center'><strong>{$row['usuario']}</strong></td>";
                                echo "<td class='text-center'><strong>{$row['fecha_prestamo']}</strong></td>";
                                echo "<td class='text-center'><strong>{$row['fecha_devolucion']}</strong></td>";
                                echo "<td class='text-center'>";
                                echo "<span class='badge ".($row['estado']=='Activo'?'bg-primary':($row['estado']=='Devuelto'?'bg-success':'bg-danger'))."\">{$row['estado']}</span>";
                                echo "<div class='mt-2' style='min-height: 38px;'>";
                                if($row['estado'] == 'Activo') {
                                    echo "<button class='btn btn-sm btn-success me-2 fw-semibold' onclick='cambiarEstado({$row['id']}, \"Devuelto\")'>Devuelto</button>";
                                    echo "<button class='btn btn-sm btn-danger me-2 fw-semibold' onclick='cambiarEstado({$row['id']}, \"Vencido\")'>Vencido</button>";
                                }
                                echo "</div>";
                                echo "</td>";
                                
                                echo "<td class='text-center'><strong>{$row['observaciones']}</strong></td>";
                                echo "<td class='text-center'>";
                                echo "<button class='btn btn-sm btn-outline-dark btn-warning' onclick='eliminarPrestamo({$row['id']})'>Eliminar</button>";
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center p-4 text-muted'>No existen registros de prestamos cargados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPrestamo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formPrestamo" onsubmit="guardarPrestamo(event)">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">Registrar Nuevo Prestamo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Solicitud Prestamo Libro *</label>
                            <select name="id_libro" class="form-select" required>
                                <option value="">Seleccione un Libro</option>
                                <?php
                                $libros = $con->query("SELECT id, titulo, stock FROM libros WHERE stock > 0");
                                while($l = $libros->fetch_assoc()) {
                                    echo "<option value='{$l['id']}'>{$l['titulo']} (Stock: {$l['stock']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Solicitud Prestamo Usuario *</label>
                            <select name="id_usuario" class="form-select" required>
                                <option value="">Seleccione Usuario</option>
                                <?php
                                $usuarios = $con->query("SELECT id, nombre, carnet FROM usuarios");
                                while($u = $usuarios->fetch_assoc()) {
                                    echo "<option value='{$u['id']}'>{$u['nombre']} (CI: {$u['carnet']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fecha de Prestamo *</label>
                            <input type="date" name="fecha_prestamo" class="form-control" value="<?php echo $fecha_actual; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fecha Devolucion *</label>
                            <input type="date" name="fecha_devolucion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Observaciones *</label>
                            <textarea name="observaciones" class="form-control" rows="2" placeholder="Deja un mensaje..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Registrar Prestamo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Javascript/prestamos.js"></script>
</body>
</html>