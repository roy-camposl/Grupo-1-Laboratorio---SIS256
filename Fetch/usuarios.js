let bootstrapModal;

document.addEventListener("DOMContentLoaded", function() {
    var modalElement = document.getElementById('modalUsuario');
    if (modalElement) {
        bootstrapModal = new bootstrap.Modal(modalElement);
    }

    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'nuevo') {
        limpiarFormulario();
        bootstrapModal.show();
    }
});

function limpiarFormulario() {
    document.getElementById('formUsuario').reset();
    document.getElementById('id').value = '';
    document.getElementById('modalTitulo').innerText = 'Registrar Usuario: ';
    document.getElementById('btnSubmitUsuario').innerText = 'Registrar';
}

function guardarUsuario(event) {
    event.preventDefault();
    var id = document.getElementById('id').value;
    var url = id ? 'update.php' : 'create.php';
    var formData = new FormData(document.getElementById('formUsuario'));

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.mensaje);
        if(data.status === 'ok') {
            bootstrapModal.hide();
            location.href = 'lista.php';
        }
    })
    .catch(error => console.error("Error:", error));
}

function editarUsuario(id) {
    fetch(`get.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        if(data.status === 'ok') {
            document.getElementById('id').value = data.datos.id;
            document.getElementById('nombre').value = data.datos.nombre;
            document.getElementById('carnet').value = data.datos.carnet;
            document.getElementById('telefono').value = data.datos.telefono;
            document.getElementById('correo').value = data.datos.correo;
            document.getElementById('modalTitulo').innerText = 'Modificar Usuario: ';
            document.getElementById('btnSubmitUsuario').innerText = 'Modificar';
            
            bootstrapModal.show();
        } else {
            alert(data.mensaje);
        }
    })
    .catch(error => console.error("Error:", error));
}

function eliminarUsuario(id) {
    if(confirm('¿Esta seguro que quieres eliminar este usuario?')) {
        fetch(`delete.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            alert(data.mensaje);
            if(data.status === 'ok') {
                document.getElementById(`fila-usuario-${id}`).remove();
            }
        })
        .catch(error => console.error("Error:", error));
    }
}