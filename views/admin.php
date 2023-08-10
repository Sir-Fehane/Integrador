
<?php
session_start();
if(!isset($_SESSION['rol']))
{
 header('location: ../index.php');
}
else
{
  if ($_SESSION["rol"] == 3) { 
    header("Location: puntoventa.php");
    exit;
  } elseif ($_SESSION["rol"] == 1) { 
    if (basename($_SERVER['PHP_SELF']) === 'admin.php') {
    } else {
        header("Location: admin.php");
        exit;
    }
  } elseif ($_SESSION["rol"] == 2) { 
    header("Location: ../index.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
<style>
  #tabla
  {
    margin: auto;
    width: 90%;
  }
  #tabla-xs
  {
    margin: auto;
    width: 60%;
  }
  h2
  {
    margin: auto;
    text-align: center;
  }
  .select-wrapper {
  margin-right: 10px;
}
@media (max-width:576) {
  #ocultar{
    display: none;
  }
}
@media (min-width: 576px){
  cont-nav{
  flex:1;}
}
</style>
<title>Administracion</title>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="col-lg-1 d-none d-sm-block">
        <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
      </div>
      <div class="col-1 col-lg-2 d-none">
      <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle d-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Menú
            </button>   
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <button class="dropdown-item" id="v-pills-inv-tab" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Inventario</button>
              <button class="dropdown-item" id="v-pills-emp-tab" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Personal</button>
              <button class="dropdown-item" id="v-pills-rep-tab" data-bs-toggle="pill" data-bs-target="#rep" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Reportes</button>
            </div>
          </div>
      </div>
      <div class="col-5 col-lg-4 d-flex align-items-center">
        <form class="d-flex" action="" method="post">
          <?php
            include "../class/database.php";
            $db = new Database();
            $db->conectarDB();
            $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
            $reg = $db->seleccionar($cadena);
            echo "<div class='me-2'>
            <select name='sucursal' class='form-select'>
            <option value='0'>Seleccionar sucursal...</option>";
            foreach ($reg as $value) 
            {
              echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
            }
            echo "<option value='999'>VER TODAS</option>";
            echo "</select>
            </div>";
            $db->desconectarDB();
            ?>
          <button type="submit" class="btn btn-primary">Elegir</button>
        </form>
      </div>
      <div class="col-lg-3 d-none d-lg-block">
        <?php
        if (isset($_SESSION['usuario'])) 
        {
          echo "<h4 class='mr-5'>Usuario: ".$_SESSION['usuario']."</h4>";
        }
        ?>
      </div>
      <div class="col-2 col-lg-1 d-flex align-items-center">
        <ul class="navbar-nav ms-auto me-0">
          <li class="nav-item">
            <a type="button" class="btn btn-sm btn-primary" href="../scripts/cerrarSesion.php">
              Cerrar sesion
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
<div class="d-lg-flex align-items-start">
  <div class="nav flex-column me-3 bg-light d-lg-flex d-none" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link" id="inventario" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Inventario</button>
    <button class="nav-link" id="personal" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Personal</button>
    <button class="nav-link" id="solicitudes" data-bs-toggle="pill" data-bs-target="#sol" type="button" role="tab" aria-controls="v-pills-rep" aria-selected="false">Solicitudes</button>
    <button class="nav-link" id="ingresos" data-bs-toggle="pill" data-bs-target="#ing" type="button" role="tab" aria-controls="v-pills-rep" aria-selected="false">Ingresos</button>
    <button class="nav-link" id="cie" data-bs-toggle="pill" data-bs-target="#cie" type="button" role="tab" aria-controls="v-pills-rep" aria-selected="false">Cierres</button>
    <button class="nav-link" id="productos" data-bs-toggle="pill" data-bs-target="#pro" type="button" role="tab" aria-controls="v-pills-rep" aria-selected="false">Productos</button>
  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <!--INVENTARIO-->
    <div class="tab-pane fade" id="inv" role="tabpanel" aria-labelledby="inventario" tabindex="0">
      <?php include 'Inventario.php'; ?>
    </div>
    <!--PERSONAL-->
    <div class="tab-pane fade" id="emp" role="tabpanel" aria-labelledby="personal" tabindex="0">
      <?php include 'Personal.php'; ?>
    </div>
    <!--Reportes-->
    <div class="tab-pane fade" id="sol" role="tabpanel" aria-labelledby="solicitude" tabindex="0">
      <?php include 'Solicitudes.php'; ?>
    </div>
    <div class="tab-pane fade" id="ing" role="tabpanel" aria-labelledby="ingresos" tabindex="0">
      <?php include 'Ingresos.php'; ?>
    </div>
    <div class="tab-pane fade" id="pro" role="tabpanel" aria-labelledby="productos" tabindex="0">
      <?php include 'Productos.php'; ?>
    </div>
    <div class="tab-pane fade" id="cie" role="tabpanel" aria-labelledby="cierre" tabindex="0">
    </div>
      </div>
</div>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>