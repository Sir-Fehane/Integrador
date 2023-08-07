<?php
session_start();
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
}
else
 {
  if ($_SESSION["rol"] == 2) {
    header("Location: ../index.php");
    exit;
  } elseif ($_SESSION["rol"] == 1) { 
    header("Location: admin.php");
    exit;
  }
 }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Solicitar</title>
    <link rel="stylesheet" href="../css/estilo.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <script src="../src/app.js"></script>
  </head>
  <body>
    <!--Header/navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="puntoventa.php">Inicio</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Perfil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../scripts/cerrarSesion.php">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--Contenido-->
    <div class="container" #id="cuerpo">
      <h2 align="center">Solicitar Insumos</h2>
      <hr>
      <div class="justify-content-center" id="contenedor">
        <div class="table-responsive">
        <form action="../scripts/soli.php" method="post">
        <table class="table table-striped table-hover">
        <!--<table class="table align-middle table-sm">-->
                    <tbody>
                    <tr>
                        <td>
                            <?php
                            include "../class/database.php";
                            $db = new Database();
                            $db->conectarDB();
                            $cadena = "SELECT INVENTARIO.NOMBRE as N, INVENTARIO.PRESENTACION as P FROM INVENTARIO WHERE INVENTARIO.ESTADO = 'ACTIVO'";
                            $reg = $db->seleccionar($cadena);
                            echo "<select name='insumo[]' class='form-select'>";
                            echo "<option value='0'>Seleccionar insumo...</option>";
                            foreach ($reg as $value) {
                                echo "<option value='" . $value->N . "'>" . $value->N . "(" . $value->P . ")</option>";
                            }
                            echo "</select>";
                            $db->desconectarDB();
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="agregarValorSeleccionado()">Añadir</button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-striped table-hover" id="tablaInsumos">
                    <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Cantidad Restante</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">Solicitar</button>
                </div>
        </form>
        </div>
    </div>
</div>
<script src="../js/bootstrap.bundle.js"></script>
<script>
      function validarNumero(event) {
    const charCode = (event.which) ? event.which : event.keyCode;

    // Permitir el punto decimal (.) y números del 0 al 9
    if (charCode == 46 || (charCode >= 48 && charCode <= 57)) {
        return true;
    }

    return false;
}
      let elementosAgregados = false;
      document.querySelector("form").addEventListener("submit", function(event) 
      {
          if (!elementosAgregados) 
          {
          event.preventDefault(); // Detener el envío del formulario
          alert("Añade al menos un insumo antes de solicitar."); // Mostrar un mensaje
          }
      });

      const insumosSeleccionados = [];

        // Evento para añadir el insumo seleccionado a la tabla
        function agregarValorSeleccionado() {
    const select = document.querySelector("select[name='insumo[]']");
    const selectedInsumo = select.value;
    const selectedInsumoText = select.options[select.selectedIndex].text;

    // Verificar si el insumo ya está en la tabla
    if (!isInsumoRepetido(selectedInsumoText)) {
        // Agregar un campo oculto al formulario con el valor del insumo seleccionado
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "insumosSeleccionados[]";
        hiddenInput.value = selectedInsumo;
        document.querySelector("form").appendChild(hiddenInput);

        // Ahora puedes agregar el valor al arreglo insumosSeleccionados
        insumosSeleccionados.push(selectedInsumo);
        // Crear nueva fila en la tabla
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${selectedInsumoText}</td>
            <td><input type="number" class="form-control form-control-sm" name='cantidad[ ]' min="0.1" step='0.1' required></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button></td>`;

            newRow.setAttribute("data-insumo",selectedInsumo);
        // Agregar la fila a la tabla
        document.getElementById("tablaInsumos").querySelector("tbody").appendChild(newRow);
        elementosAgregados = true;
        }
      };

    // Función para verificar si un insumo ya está en la tabla
    function isInsumoRepetido(insumo) {
        const tablaInsumos = document.getElementById("tablaInsumos");
        const insumos = tablaInsumos.querySelectorAll("td:first-child");
        for (let i = 0; i < insumos.length; i++) {
            if (insumos[i].textContent === insumo) {
                return true;
            }
        }
        return false;
    }

    // Función para eliminar una fila de la tabla
    function eliminarFila(btn) {
    const fila = btn.closest("tr");
    const insumo = fila.getAttribute("data-insumo");

    // Buscar el insumo en el arreglo utilizando el mismo enfoque que en agregarValorSeleccionado()
    const index = insumosSeleccionados.indexOf(insumo);
    if (index !== -1) {
        insumosSeleccionados.splice(index, 1);
    }

    // Actualizar la variable elementosAgregados
    elementosAgregados = insumosSeleccionados.length > 0;

    fila.remove();
}

</script>
</body>
</html>