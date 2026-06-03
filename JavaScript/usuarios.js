var modalUsuario;

window.onload = function() {
    var modalElement = document.getElementById('modalUsuario');
    if (modalElement) {
        modalUsuario = new bootstrap.Modal(modalElement);
    }

    if (window.location.search.indexOf('action=nuevo') !== -1) {
        limpiarFormulario();
        modalUsuario.show();
    }
};

function limpiarFormulario() {
    document.getElementById('formUsuario').reset();
    document.getElementById('id').value = '';
    document.getElementById('modalTitulo').innerText = 'Registrar Usuario';
}

function guardarUsuario(event) {
    event.preventDefault();
    
    var id = document.getElementById('id').value;
    var url = 'create.php';
    if (id !== '') {
        url = 'update.php';
    }

    var formData = new FormData(document.getElementById('formUsuario'));

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(data.mensaje);
        if (data.status === 'ok') {
            modalUsuario.hide();
            window.location.href = 'lista.php';
        }
    });
}

function editarUsuario(id) {
    fetch('get.php?id=' + id)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status === 'ok') {
            document.getElementById('id').value = data.datos.id;
            document.getElementById('nombre').value = data.datos.nombre;
            document.getElementById('carnet').value = data.datos.carnet;
            document.getElementById('telefono').value = data.datos.telefono;
            document.getElementById('correo').value = data.datos.correo;
            document.getElementById('modalTitulo').innerText = 'Modificar Usuario';
            modalUsuario.show();
        } else {
            alert(data.mensaje);
        }
    });
}

function eliminarUsuario(id) {
    if (confirm('¿Seguro que desea eliminar este usuario?')) {
        fetch('delete.php?id=' + id)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            alert(data.mensaje);
            if (data.status === 'ok') {
                var fila = document.getElementById('fila-usuario-' + id);
                if (fila) {
                    fila.remove();
                }
            }
        });
    }
}