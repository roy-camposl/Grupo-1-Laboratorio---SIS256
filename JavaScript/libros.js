var modalLibro;

window.onload = function() {
    var modalElement = document.getElementById('modalLibro');
    if (modalElement) {
        modalLibro = new bootstrap.Modal(modalElement);
    }

    if (window.location.search.indexOf('action=nuevo') !== -1) {
        limpiarFormulario();
        modalLibro.show();
    }
};

function limpiarFormulario() {
    document.getElementById('formLibro').reset();
    document.getElementById('id').value = '';
    document.getElementById('modalTitulo').innerText = 'Registrar Libro';
}

function guardarLibro(event) {
    event.preventDefault();
    
    var stock = document.getElementById('stock').value;
    if (parseInt(stock) < 0) {
        alert("El stock no puede ser un número negativo.");
        return;
    }

    var id = document.getElementById('id').value;
    var url = 'create.php';
    if (id !== '') {
        url = 'update.php';
    }

    var formData = new FormData(document.getElementById('formLibro'));

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
            modalLibro.hide();
            window.location.href = 'lista.php';
        }
    });
}

function editarLibro(id) {
    fetch('get.php?id=' + id)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.status === 'ok') {
            document.getElementById('id').value = data.datos.id;
            document.getElementById('titulo').value = data.datos.titulo;
            document.getElementById('autor').value = data.datos.autor;
            document.getElementById('isbn').value = data.datos.isbn;
            document.getElementById('categoria').value = data.datos.categoria;
            document.getElementById('stock').value = data.datos.stock;
            document.getElementById('modalTitulo').innerText = 'Modificar Libro';
            modalLibro.show();
        } else {
            alert(data.mensaje);
        }
    });
}

function eliminarLibro(id) {
    if (confirm('¿Seguro que desea eliminar este libro?')) {
        fetch('delete.php?id=' + id)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            alert(data.mensaje);
            if (data.status === 'ok') {
                var fila = document.getElementById('fila-libro-' + id);
                if (fila) {
                    fila.remove();
                }
            }
        });
    }
}