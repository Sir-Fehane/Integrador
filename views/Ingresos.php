<?php
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
}
else
 {
  if ($_SESSION["rol"] == 2) {
    header("Location: ../index.php");
    exit;
  } elseif ($_SESSION["rol"] == 3) { 
    header("Location: puntoventa.php");
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
  <title>Solicitudes</title>
</head>
<body>
<?php
if (isset($_POST['sucursal'])) 
{
  $db = new Database();
  $db->conectarDB();
  $sucursalId = $_POST['sucursal'];
  if ($sucursalId != 0 && $sucursalId != 999)
  {
    $consulta = "SELECT NOMBRE FROM SUCURSALES WHERE ID_SUC = $sucursalId";
    $sucursal = $db->seleccionar($consulta);
    $Nombre = $sucursal[0]->NOMBRE;
    echo "<h2>Sucursal $Nombre</h2>";
  }
if($sucursalId == 0) 
{
  ?>
  <div class="container">
      <h4 align="center">Elige una sucursal para iniciar.</h4>
  </div>
  <?php
}
else
{
?>
<br>
<?php
}
if (isset($_POST['sucursal']) && $_POST['sucursal'] != 0) {
  $sucursalId = $_POST['sucursal'];
  if ($sucursalId != 0 && $sucursalId != 999) {
    $consulta = "SELECT Fecha, TotalEfectivo AS 'Efectivo', TotalTarjeta AS 'Tarjeta', TotalIngresos AS 'Total' FROM BitacoraIngresos Where Sucursal = $sucursalId AND FECHA BEETWEEN;";
    $tabla = $db->seleccionar($consulta);
  } elseif ($sucursalId == 999) 
  {
    $consulta = "SELECT Sucursal, Fecha, TotalEfectivo AS 'Efectivo', TotalTarjeta AS 'Tarjeta', TotalIngresos AS 'Total' FROM BitacoraIngresos;";
    $tabla = $db->seleccionar($consulta);
  }

  echo "<table class='table table-hover tabla-xs' id='tabla'>";
  echo "<thead class='table-primary' align='center'>";
  echo "<tr>";
  if ($sucursalId == 999) {
    echo "<th>Sucursal</th>";
  }
  echo "<th class='col-2 col-lg-3'>Fecha</th>";
  echo "<th class='col-1 col-lg-1'>Efectivo</th>";
  echo "<th class='col-1 col-lg-1'>Tarjeta</th>";
  echo "<th class='col-1 col-lg-1'>Total</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody align='center'>";
  foreach ($tabla as $registro) {
    echo "<tr>";
    if ($sucursalId == 999) {
      echo "<td>$registro->Sucursal</td>";
    }
    echo "<td>$registro->Fecha</td>";
    echo "<td>$registro->Efectivo</td>";
    echo "<td>$registro->Tarjeta</td>";
    echo "<td>$registro->Total</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
}
}
else
{
  ?>
  <div class="container">
      <h4 align="center">Elige una sucursal para iniciar.</h4>
  </div>
  <?php
}
?>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>