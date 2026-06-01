<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Libros</title>
    <style>
        body {
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        #pantalla-mensaje {
            margin-bottom: 20px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .modal.activo {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-contenido {
            background-color: white;
            padding: 30px;
            border: 1px solid #ddd;
            max-width: 400px;
            text-align: center;
        }
        .modal-mensaje {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .modal-exito {
            color: #28a745;
        }
        .modal-error {
            color: #dc3545;
        }
        .modal-boton {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .modal-boton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

  <div class="container">
    <h2>Registrar un Libro</h2>
    
    <div id="pantalla-mensaje"></div>
    
    <form id="formulario-libro">
      <div class="form-group">
          <label>Título del libro:</label>
          <input type="text" name="titulo" required>
      </div>
      
      <div class="form-group">
          <label>Autor:</label>
          <input type="text" name="autor" required>
      </div>
      
      <div class="form-group">
          <label>ISBN:</label>
          <input type="text" name="isbn" required>
      </div>
      
      <div class="form-group">
          <label>Categoría:</label>
          <input type="text" name="categoria" required>
      </div>
      
      <div class="form-group">
          <label>Stock:</label>
          <input type="number" name="stock" value="1" required>
      </div>
      
      <button type="submit">Registrar Libro</button>
    </form>
  </div>

  <div id="modal" class="modal">
    <div class="modal-contenido">
      <div id="modal-mensaje" class="modal-mensaje"></div>
      <button class="modal-boton" onclick="cerrarModal()">Cerrar</button>
    </div>
  </div>

  <script>
    function mostrarModal(mensaje, tipo) {
        var modal = document.getElementById("modal");
        var modalMensaje = document.getElementById("modal-mensaje");
        
        modalMensaje.textContent = mensaje;
        modalMensaje.className = "modal-mensaje modal-" + tipo;
        modal.classList.add("activo");
    }

    function cerrarModal() {
        var modal = document.getElementById("modal");
        modal.classList.remove("activo");
    }

    document.getElementById("formulario-libro").addEventListener("submit", function(e) {
        e.preventDefault();
        var datos = new FormData(this);

        fetch("create.php", {
            method: "POST",
            body: datos
        })
        .then(function(respuesta) {
            return respuesta.json();
        })
        .then(function(resultado) {
            if (resultado.status === "ok") {
                mostrarModal(resultado.mensaje, "exito");
                document.getElementById("formulario-libro").reset();
            } else {
                mostrarModal(resultado.mensaje, "error");
            }
        });
    });
  </script>

</body>
</html>