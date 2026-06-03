function cargarPrestamos() {
    var tabla = document.getElementById('tablaPrestamos');
    if (!tabla) return;

    var idLibro = document.getElementById('filtroLibro').value;
    var idUsuario = document.getElementById('filtroUsuario').value;
    var estado = document.getElementById('filtroEstado').value;

    var url = 'lista_api.php?id_libro=' + idLibro + '&id_usuario=' + idUsuario + '&estado=' + estado;

    fetch(url)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        tabla.innerHTML = '';
        if (data.status === 'ok' && data.prestamos.length > 0) {
            for (var i = 0; i < data.prestamos.length; i++) {
                var p = data.prestamos[i];
 
                var hoy = new Date();
                hoy.setHours(0, 0, 0, 0); 
                
                var fDev = new Date(p.fecha_devolucion);

                fDev.setMinutes(fDev.getMinutes() + fDev.getTimezoneOffset());
                fDev.setHours(0, 0, 0, 0);

                var vencido = (p.estado === 'Activo' && fDev < hoy);

                var estilo = '';
                var claseBadge = 'bg-primary'; // Activo
                if (p.estado === 'Devuelto') {
                    claseBadge = 'bg-primary'; // Devuelto
                } else if (p.estado === 'Vencido') {
                    claseBadge = 'bg-danger'; // Vencido
                }

                if (vencido) {
                    estilo = 'class="prestamo-vencido"';
                }

                var botones = '';
                if (p.estado === 'Activo') {
                    botones = '<button onclick="cambiarEstado(' + p.id + ', \'Devuelto\')" class="btn btn-sm btn-primary me-2" style="background-color: #004085; border-color: #004085;">Devuelto</button>' +
                              '<button onclick="cambiarEstado(' + p.id + ', \'Vencido\')" class="btn btn-sm btn-danger" style="background-color: #cc0000; border-color: #cc0000;">Vencido</button>';
                } else {
                    botones = '<button onclick="eliminarPrestamo(' + p.id + ')" class="btn btn-sm btn-danger" style="background-color: #cc0000; border-color: #cc0000;">Eliminar</button>';
                }

                var filaHTML = '<tr ' + estilo + '>' +
                    '<td><strong>' + p.titulo + '</strong></td>' +
                    '<td>' + p.nombre + '</td>' +
                    '<td>' + p.fecha_prestamo + '</td>' +
                    '<td>' + p.fecha_devolucion + '</td>' +
                    '<td><span class="badge ' + claseBadge + '">' + p.estado + '</span></td>' +
                    '<td class="text-center">' + botones + '</td>' +
                    '</tr>';
                
                tabla.innerHTML += filaHTML;
            }
        } else {
            tabla.innerHTML = '<tr><td colspan="6" class="text-center p-4">Sin resultados</td></tr>';
        }
    });
}

function filtrarPrestamos() {
    cargarPrestamos();
}

function guardarPrestamo(event) {
    event.preventDefault();
    
    var fd = new FormData();
    fd.append('id_libro', document.getElementById('id_libro').value);
    fd.append('id_usuario', document.getElementById('id_usuario').value);
    fd.append('fecha_prestamo', document.getElementById('fecha_prestamo').value);
    fd.append('fecha_devolucion', document.getElementById('fecha_devolucion').value);
    fd.append('observaciones', document.getElementById('observaciones').value);

    fetch('create.php', {
        method: 'POST',
        body: fd
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(data.mensaje);
        if (data.status === 'ok') {
            document.getElementById('formPrestamo').reset();

            var modalEl = document.getElementById('modalPrestamo');
            var modalInst = bootstrap.Modal.getInstance(modalEl);
            if (modalInst) {
                modalInst.hide();
            }
            cargarPrestamos();
        }
    });
}

function cambiarEstado(id, est) {
    if (confirm('¿Cambiar estado a ' + est + '?')) {
        var fd = new FormData();
        fd.append('id', id);
        fd.append('estado', est);
        
        fetch('update.php', {
            method: 'POST',
            body: fd
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            alert(data.mensaje);
            cargarPrestamos();
        });
    }
}

function eliminarPrestamo(id) {
    if (confirm('¿Seguro que desea eliminar este préstamo?')) {
        var fd = new FormData();
        fd.append('id', id);
        
        fetch('delete.php', {
            method: 'POST',
            body: fd
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            alert(data.mensaje);
            cargarPrestamos();
        });
    }
}