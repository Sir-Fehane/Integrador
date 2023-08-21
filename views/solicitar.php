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
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <script src="../src/app.js"></script>
  </head>
  <body>
    <!--Header/navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php" id="logo">Toy's Pizza</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="puntoventa.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cocina.php">Cocina</a>
          </li>
          <li>
            <a class="nav-link" href="pendientes.php">Pendientes</a>
          </li>
          <li>
            <h6 id="miTabla"></h6>
          </li>
          <li>
            <a class="nav-link" href="cierre.php">Cierre</a>
          </li>
          <li>
            <a class="nav-link" href="solicitar.php">Solicitar</a>
          </li>
          <li>
            <a class="nav-link" href="entrada.php">Entrada</a>
          </li>
          <li>
            <a class="nav-link" href="terminadas.php">Entregas</a>
          </li>
          <li>
            <a class="nav-link" href="disponibles.php">Disponibilidad</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="verperfilv1.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
      <hr>
      <h2 align="center">Solicitar Insumos</h2>
      <hr>
      <h4 align="center">Selecciona los insumos que deseas solicitar:</h4>
      <div class="justify-content-center" id="contenedor">
        <div class="table-responsive">
        <form action="../scripts/soli.php" method="post">
        <table class="table table-hover">
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

                <table class="table table-hover" id="tablaInsumos">
                    <thead class="table-dark">
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
                    <button class="btn btn-primary" type="submit" id="bloqueo" onclick="cambiarContenido()">Solicitar</button>
                </div>
        </form>
        </div>
    </div>
</div>
<script src="../js/bootstrap.bundle.js"></script>
<script>
              function validarNumero(event) {
    const charCode = (event.which) ? event.which : event.keyCode;

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
          event.preventDefault();
          alert("Añade al menos un insumo antes de solicitar."); 
          }
      });

      const insumosSeleccionados = [];

        function agregarValorSeleccionado() {
    const select = document.querySelector("select[name='insumo[]']");
    const selectedInsumo = select.value;
    const selectedInsumoText = select.options[select.selectedIndex].text;

    if (selectedInsumo !== "" && selectedInsumoText !== "Seleccionar insumo...") 
    {

    if (!isInsumoRepetido(selectedInsumoText)) {

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "insumosSeleccionados[]";
        hiddenInput.value = selectedInsumo;
        document.querySelector("form").appendChild(hiddenInput);


        insumosSeleccionados.push(selectedInsumo);

        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${selectedInsumoText}</td>
            <td><input type="number" class="form-control form-control-sm" name='cantidad[ ]' min="0.1" step='0.1' placeholder='Ingresa la cantidad restante:'
            required onkeypress='return validarNumero(event)' ></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>`;

            newRow.setAttribute("data-insumo",selectedInsumo);

        document.getElementById("tablaInsumos").querySelector("tbody").appendChild(newRow);
        elementosAgregados = true;
        }
    }
      };

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

    function eliminarFila(btn) {
    const fila = btn.closest("tr");
    const insumo = fila.getAttribute("data-insumo");


    const index = insumosSeleccionados.indexOf(insumo);
    if (index !== -1) {
        const newQuantity = parseInt(insumosSeleccionados[index]) - 1;
        

        if (newQuantity > 0) {
            insumosSeleccionados[index] = newQuantity.toString();
        } else {

            insumosSeleccionados.splice(index, 1);
            

            const hiddenInput = document.querySelector(`input[name='insumosSeleccionados[]'][value='${insumo}']`);
            if (hiddenInput) {
                hiddenInput.remove();
            }
        }
    }

    elementosAgregados = insumosSeleccionados.length > 0;

    fila.remove();
}
document.addEventListener("DOMContentLoaded", function() 
        {
    var boton = document.getElementById("bloqueo");
    var form = document.querySelector("form");

    form.addEventListener("submit", function() 
    {
        boton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...';
        boton.disabled = true;
    });
});
</script>
</body>
</html>