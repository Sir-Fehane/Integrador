<?php
session_start();
if(!isset($_SESSION['rol']))
{
 header('location: ../index.php');
}
else
{
  if ($_SESSION["rol"] == 3) { // Admin
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
</style>
<title>Administracion</title>
</head>
<body>
  <?php
    session_start();
  ?>
<div class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="col-lg-1 d-none d-sm-block">
        <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
      </div>
      <div class="col-1 col-lg-2 d-flex">
        <div class="nav flex-column me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle d-block d-lg-none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Menú
            </button>   
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <button class="dropdown-item" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Inventario</button>
              <button class="dropdown-item" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Personal</button>
              <button class="dropdown-item" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#sol" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Solicitudes</button>
              <button class="dropdown-item" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#ing" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Ingresos</button>
            </div>
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
            <a type="button" class="btn btn-sm btn-primary" href="../scripts/cerrarsesion.php">
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
    <button class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Inventario</button>
    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Personal</button>
    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#sol" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Solicitudes</button>
    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#ing" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Ingresos</button>
  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <!--INVENTARIO-->
    <div class="tab-pane fade" id="inv" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
    <?php
      include 'Inventario.php';
    ?>
    </div>
    <!--PERSONAL-->
    <div class="tab-pane fade" id="emp" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
    <?php
      include 'Personal.php';
    ?>
    </div>
    <!--SOLICITUDES-->
    <div class="tab-pane fade" id="sol" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
    <?php
      include 'Solicitudes.php';
    ?>
    </div>
    <!--INGRESOS-->
    <div class="tab-pane fade" id="ing" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
    <?php
      include 'Ingresos.php';
    ?>
    </div>
    </div>
    </div>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>