<?php
session_start();
 include "../class/database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/boot.css">
<style>
</style>
<title>Mis pedidos</title>
</head>
<body>
    <!-- navbar/header -->
<nav class="navbar navbar-expand-lg he">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#">
                <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
                Toy's Pizza
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active navtext text-dark" aria-current="page" href="../index.php">Inicio</a>
              </li>
                </ul>
            </ul>
              <li class="nav-item navtext">
                <div class="container">
                  <div class="d-flex justify-content">
                  </div>
              </div>
              </li>
          </div>
        </div>
      </nav>

      <div class="d-lg-flex align-items-start">
  <div class="nav flex-column me-3 d-lg-flex d-none " id="v-pills-tab" role="tablist" aria-orientation="vertical" style="background-color: #BB0E10;" >
    <button class="nav-link active d-none" id="none" data-bs-toggle="pill" data-bs-target="#non" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false"></button>
    <button class="nav-link text-dark" id="inventario" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Pendientes</button>
    <button class="nav-link text-dark" id="productos" data-bs-toggle="pill" data-bs-target="#pro" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">En proceso</button>
    <button class="nav-link text-dark" id="sucursales" data-bs-toggle="pill" data-bs-target="#suc" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Terminadas</button>
    <button class="nav-link text-dark" id="personal" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Historial</button>
  </div>
  <div class="nav flex-row mb-3 bg-light d-flex d-sm-none" id="v-pills-tab" role="tablist" aria-orientation="horizontal" style="background-color: #BB0E10;">
  <button class="nav-link active d-none" id="none" data-bs-toggle="pill" data-bs-target="#non" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false"></button>
  <button class="nav-link text-dark col-3" id="inventario" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Pendientes</button>
  <button class="nav-link text-dark col-3" id="productos" data-bs-toggle="pill" data-bs-target="#pro" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">En proceso</button>
  <button class="nav-link text-dark col-3" id="sucursales" data-bs-toggle="pill" data-bs-target="#suc" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Terminadas</button>
  <button class="nav-link text-dark col-3" id="personal" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Historial</button>
</div>
  <div class="tab-content w-100" id="v-pills-tabContent">
  <div class="tab-pane fade show active " id="non" role="tabpanel" aria-labelledby="none" tabindex="0">
    <h4 align="center">Selecciona el estado que quieres visualizar </h4>
    <center> <img src="../img/pizza.png" alt=""  style="height: 300px; width: 300px;  align-items: center;"> </center>
    </div>
    <!--PENDIENTES DE ACEPTAR-->
    <div class="tab-pane fade" id="inv" role="tabpanel" aria-labelledby="inventario" tabindex="0">
      <?php include '../scripts/pendientes.php'; ?>
    </div>
    <!--EN PROCESO-->
    <div class="tab-pane fade" id="pro" role="tabpanel" aria-labelledby="productos" tabindex="0">
      <?php include '../scripts/enproceso.php'; ?>
    </div>
    <!--TERMINADAS POR RECOGER-->
    <div class="tab-pane fade" id="suc" role="tabpanel" aria-labelledby="sucursales" tabindex="0">
      <?php include '../scripts/terminadas.php'; ?>
    </div>
    <!--ORDENES RECOGIDAS-->
    <div class="tab-pane fade" id="emp" role="tabpanel" aria-labelledby="sucursales" tabindex="0">
      <?php include '../scripts/historial.php'; ?>
    </div>
      </div>
</div>

<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>