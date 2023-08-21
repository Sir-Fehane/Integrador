<?php
session_start();
include '../class/database.php';
$conexion = new Database();
$conexion->conectarDB();
if (!isset($_SESSION['rol'])) {
  header('Location: ../index.php');
} else {
  if ($_SESSION["rol"] == 2) {
    header("Location: ../index.php");
    exit;
  } elseif ($_SESSION["rol"] == 1) {
    header("Location: admin.php");
    exit;
  }
}

$cons = "SELECT SUCURSALES.ID_SUC FROM SUCURSALES INNER JOIN EMPLEADO_SUCURSAL ON EMPLEADO_SUCURSAL.SUCURSAL=SUCURSALES.ID_SUC INNER JOIN USUARIOS ON USUARIOS.ID_USUARIO=EMPLEADO_SUCURSAL.EMPLEADO WHERE USUARIOS.ID_USUARIO=" . $_SESSION["IDUSU"] . "";
$resultadocons = $conexion->seleccionar($cons);
foreach ($resultadocons as $abc) {
  $_SESSION['IDSUCUR'] = $abc->ID_SUC;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toy's pizza</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>

<body>
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
  <div class="container">
    <div class="row" id="renglon">
      <?php
      $consulta = "SELECT P.NOMBRE as N, PS.PS_ID as ID, PS.SUCURSAL as SUC, P.img_prod as IMG 
                FROM PROD_SUC PS 
                INNER JOIN PRODUCTOS as P ON PS.PRODUCTO = P.CODIGO
                WHERE P.ESTADO = 'ACTIVO' AND PS.SUCURSAL = $_SESSION[IDSUCUR] GROUP BY N";

      $reg = $conexion->seleccionar($consulta);
      foreach ($reg as $value) { ?>
        <div class="col-6 col-md-5 col-lg-4">
          <div class="card justify-content-center" id="item" data-tamaño="" style="height:225px">
            <div class="card-content">
              <?php $imagen = $value->IMG; ?>
              <span class="titulo-item"><?php echo $value->N; ?></span>
              <div class="d-lg-none d-block">
                <img src="<?php echo $imagen; ?>" class="img-item" style="width: 125px; height:100px">
              </div>
              <div class="d-none d-lg-block">
                <img src="<?php echo $imagen; ?>" class="img-item" style="width: 250px; height:150px">
              </div>
              <div class="btn-group" role="group" aria-label="Basic example">
                <!-- Botón "X" -->
                <form action="../scripts/procesar_botones.php" method="post">
                  <input type="hidden" name="x_button" value="<?php echo $value->ID; ?>">
                  <button type="submit" class="btn btn-danger" name="x_button" value="<?php echo $value->ID; ?>">
                    <i class="bi bi-x"></i>
                  </button>
                </form>
                <!-- Botón "check" -->
                <form action="../scripts/procesar_botones.php" method="post">
                  <input type="hidden" name="check_button" value="<?php echo $value->ID; ?>">
                  <button type="submit" class="btn btn-success" name="check_button" value="<?php echo $value->ID; ?>">
                    <i class="bi bi-check"></i>
                  </button>
                </form>
              </div>

            </div>
            
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>