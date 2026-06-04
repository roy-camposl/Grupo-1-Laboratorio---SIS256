let bootstrapModal;

document.addEventListener("DOMContentLoaded", function() {
    var modalElement = document.getElementById('modalPrestamo');
    if (modalElement) {
        bootstrapModal = new bootstrap.Modal(modalElement);
    }
});

function guardarPrestamo(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById('formPrestamo'));

    fetch('create.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.mensaje);
        if(data.status === 'ok') {
            bootstrapModal.hide();
            location.reload();
        }
    })
    .catch(err => console.error("Error:", err));
}

function cambiarEstado(id, nuevoEstado) {
    if(confirm(`¿Confirma cambiar el estado a ${nuevoEstado}?`)) {
        fetch(`update_status.php?id=${id}&estado=${nuevoEstado}`)
        .then(res => res.json())
        .then(data => {
            alert(data.mensaje);
            if(data.status === 'ok') {
                location.reload();
            }
        })
        .catch(err => console.error("Error:", err));
    }
}

function eliminarPrestamo(id) {
    if(confirm('¿Esta seguro de eliminar de forma permanente este registro?')) {
        fetch(`delete.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            alert(data.mensaje);
            if(data.status === 'ok') {
                document.getElementById(`fila-prestamo-${id}`).remove();
            }
        })
        .catch(err => console.error("Error:", err));
    }
}

function filtrarPrestamos() {
    var busqueda = document.getElementById('filtroBusqueda').value.toLowerCase();
    var estado = document.getElementById('filtroEstado').value;
    var filas = document.querySelectorAll('#tablaPrestamos tbody tr');

    filas.forEach(fila => {
        var libro = fila.getAttribute('data-libro') ? fila.getAttribute('data-libro').toLowerCase() : '';
        var usuario = fila.getAttribute('data-usuario') ? fila.getAttribute('data-usuario').toLowerCase() : '';
        var filaEstado = fila.getAttribute('data-estado');

        var coincideTexto = libro.includes(busqueda) || usuario.includes(busqueda);
        var coincideEstado = (estado === 'Todos') || (filaEstado === estado);

        if(coincideTexto && coincideEstado) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}