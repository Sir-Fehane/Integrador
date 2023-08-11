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
    <title>Document</title>
    <link rel="stylesheet" href="../css/estilo.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <script src="../src/app.js"></script>
  </head>
  <body>
    <!--Header/navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="puntoventa.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cocina.PHP">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="cierre.php">Cierre</a>
            </li>
            <li>
              <a class="nav-link" href="solicitar.php">Solicitar</a>
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
      <h2 align="center">Cierre del día</h2>
      <hr>
      <div class="justify-content-center" id="contenedor">
        <div class="table-responsive">
        <form action="../scripts/guardarcierre.php" method="post">
          <table class="table align-middle table-sm">
            <tbody>
              <?php
                include '../class/database.php';
                $conexion = new database();
                $conexion->conectarDB();
                $consulta ="SELECT INVENTARIO.NOMBRE as N, INVENTARIO.PRESENTACION as P FROM INVENTARIO WHERE INVENTARIO.ESTADO = 'ACTIVO'";
                $reg = $conexion->seleccionar($consulta);
              foreach($reg as $value){
                echo"
                <tr>
                  <th scope='row'><label class='control-label' for='$value->N'>$value->N</label> </th>
                  <td colspan='2' class='table-active'>
                  <input type='number' name='cantidades[$value->N]' class='form-control' onkeypress='return validarNumero(event)' 
                  placeholder='Ingresa la cantidad sobrante del insumo:' required min='0.1' step='0.1'> (<label class='control-label' for='$value->P'>$value->P</label>)</td>
                </tr>                
                ";
              }             
              ?>             
            </tbody>
            </table>
            <br>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Guardar</button>
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
    </script>
  </body>
</html>

