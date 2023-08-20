<?php
session_start();
include '../class/database.php';
$conexion = new Database();
$conexion->conectarDB();
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

$cons="SELECT SUCURSALES.ID_SUC FROM SUCURSALES INNER JOIN EMPLEADO_SUCURSAL ON EMPLEADO_SUCURSAL.SUCURSAL=SUCURSALES.ID_SUC INNER JOIN USUARIOS ON USUARIOS.ID_USUARIO=EMPLEADO_SUCURSAL.EMPLEADO WHERE USUARIOS.ID_USUARIO=".$_SESSION["IDUSU"]."";
$resultadocons=$conexion->seleccionar($cons);
foreach($resultadocons as $abc)
{
  $_SESSION['IDSUCUR']=$abc->ID_SUC;

}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy's pizza</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
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
        <?php
        
        ?>
    </div>
    <script src="../js/bootstrap.bundle.js"></script>    
</body>
</html>