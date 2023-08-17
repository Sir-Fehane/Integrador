<?php
session_start();
include '../class/database.php';
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <title>Sucursales</title>
</head>
<body>
<div class="container mt-3">
<div class="btn-group d-flex bg-light" role="group" style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <a class="btn btn-warning flex-fill" href="admin.php">Volver al inicio</a>
    <a class="btn btn-primary flex-fill" href="Inventario.php">Inventario</a>
    <a class="btn btn-primary flex-fill" href="Ordenes.php">Ordenes</a>
    <a class="btn btn-primary flex-fill" href="Productos.php">Productos</a>
    <a class="btn btn-primary flex-fill disabled" href="Sucursales.php" aria-disabled="true">Sucursales</a>
    <a class="btn btn-primary flex-fill" href="Personal.php">Personal</a>
    <a class="btn btn-primary flex-fill" href="Solicitudes.php">Solicitudes</a>
    <a class="btn btn-primary flex-fill" href="Ingresos.php">Ingresos</a>
    <a class="btn btn-primary flex-fill" href="ReporCierre.php">Cierres</a>
    <a class="btn btn-primary flex-fill" href="Movimientos.php">Movimientos en inv</a>
    <a class="btn btn-primary flex-fill" href="Merma.php">Merma</a>
</div>
</div>
<?php
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB();
    echo "<h4 align='center'>Listado de <strong>sucursales</strong>";
    echo
    "</h4>"; ?>
<?php
$db = new Database();
$db->conectarDB();
?>
<br>
<div class="d-flex justify-content-center">
  <a class="btn btn-primary mb-3" href="../scripts/NuevoSuc.php" role="button">Crear sucursal</a>
</div>
<div class="container d-lg-none d-block">
  <h4 align="center">Desliza la tabla para ver toda la informacion</h4>
</div>
<?php
    $consulta = "SELECT ID_SUC, NOMBRE AS 'Nombre', DIRECCION AS 'Direccion', TELEFONO AS 'Telefono' 
    FROM SUCURSALES
    WHERE ESTADO = 'ACTIVO'";
    $tabla = $db->seleccionar($consulta);
    ?>
    <div class="container-fluid justify-content-center mr-3">
      <div class="table-responsive">
        <?php
    echo "<table class='table table-hover' id='DetalleSuc'>";
    echo "<thead class='table-primary' align='center'>";
    echo "<tr>";
    echo "<th class='col-5 col-lg-3 sortable'>Nombre</th>";
    echo "<th class='col-4 col-lg-3 sortable'>Direccion</th>";
    echo "<th class=' col-lg-3 sortable'>Telefono</th>";
    echo "<th class='col-lg-3'>Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody align='center'>";
    foreach ($tabla as $registro) {
        echo "<tr>";
        echo "<td>$registro->Nombre</td>";
        echo "<td>$registro->Direccion</td>";
        echo "<td>$registro->Telefono</td>";
        ?>
        <td class="col-6 col-lg-3">
            <form action="../scripts/EditarSuc.php" method="post">
        <input type="hidden" name="suc" value="<?php echo $registro->ID_SUC; ?>">
        <input type="hidden" name="nom" value="<?php echo $registro->Nombre; ?>">
        <input type="hidden" name="dir" value="<?php echo $registro->Direccion; ?>">
        <input type="hidden" name="tel" value="<?php echo $registro->Telefono; ?>">
        <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
            </form>
            <form action="../scripts/EliminarSuc.php" method="post">
              <input type="hidden" name="suc" value="<?php echo $registro->ID_SUC; ?>">
              <button type="submit" class="btn btn-sm btn-danger" name="eliminar" onclick="return confirm('¿Estás seguro que deseas eliminar la sucursal?')">Borrar</button>
            </form>
        </td>
        <?php
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    $db->desconectarDB();
    ?>
      </div>
    
</div>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#DetalleSuc').DataTable();
    });
  </script>
</body>
</html>