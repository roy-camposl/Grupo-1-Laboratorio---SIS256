let bootstrapModal;

document.addEventListener("DOMContentLoaded", function() {
    var modalElement = document.getElementById('modalLibro');
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
    document.getElementById('formLibro').reset();
    document.getElementById('id').value = '';
    document.getElementById('modalTitulo').innerText = 'Registrar Libro: ';
    document.getElementById('btnSubmitLibro').innerText = 'Registrar';
}

function guardarLibro(event) {
    event.preventDefault();

    var stockInput = document.getElementById('stock').value;
    if (parseInt(stockInput) < 0) {
        alert("El stock no puede ser un numero negativo.");
        return;
    }

    var id = document.getElementById('id').value;
    var url = id ? 'update.php' : 'create.php';
    var formData = new FormData(document.getElementById('formLibro'));

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

function editarLibro(id) {
    fetch(`get.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        if(data.status === 'ok') {
            document.getElementById('id').value = data.datos.id;
            document.getElementById('titulo').value = data.datos.titulo;
            document.getElementById('autor').value = data.datos.autor;
            document.getElementById('isbn').value = data.datos.isbn;
            document.getElementById('categoria').value = data.datos.categoria;
            document.getElementById('stock').value = data.datos.stock;
            document.getElementById('modalTitulo').innerText = 'Modificar Libro: ';
            document.getElementById('btnSubmitLibro').innerText = 'Modificar';
            
            bootstrapModal.show();
        } else {
            alert(data.mensaje);
        }
    })
    .catch(error => console.error("Error:", error));
}

function eliminarLibro(id) {
    if(confirm('¿Esta seguro que desea eliminar el registro del catalogo del libro?')) {
        fetch(`delete.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            alert(data.mensaje);
            if(data.status === 'ok') {
                document.getElementById(`fila-libro-${id}`).remove();
            }
        })
        .catch(error => console.error("Error:", error));
    }
}