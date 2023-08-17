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
  <title>Movimientos</title>
</head>
<body>
<div class="container mt-3">
<div class="btn-group d-flex bg-light" role="group" style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <a class="btn btn-warning flex-fill" href="admin.php">Volver al inicio</a>
    <a class="btn btn-primary flex-fill" href="Inventario.php">Inventario</a>
    <a class="btn btn-primary flex-fill" href="Ordenes.php">Órdenes</a>
    <a class="btn btn-primary flex-fill" href="Productos.php">Productos</a>
    <a class="btn btn-primary flex-fill" href="Sucursales.php">Sucursales</a>
    <a class="btn btn-primary flex-fill" href="Personal.php">Personal</a>
    <a class="btn btn-primary flex-fill" href="Solicitudes.php">Solicitudes</a>
    <a class="btn btn-primary flex-fill" href="Ingresos.php">Ingresos</a>
    <a class="btn btn-primary flex-fill" href="ReporCierre.php">Cierres</a>
    <a class="btn btn-primary flex-fill disabled" href="Movimientos.php" aria-disabled="true">Movimientos en inv</a>
    <a class="btn btn-primary flex-fill" href="Merma.php">Merma</a>
</div>
</div>
<?php
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB();
    echo "<h4 align='center'>Reporte de <strong>movimientos de inventario</strong> de todas las sucursales. ";
    echo
    "</h4>"; ?>
    <h4 align='center'>Selecciona los filtros según tu necesidad</h4>
    <div class="container">
    <form class="" method="post">
        <div class="row">
            <div class="col-lg-4 col-12 mt-3">
                <label for="mov">Buscar por movimiento:</label>
                <select name="mov" class="form-select">
                    <option value="ENTRADA">Ver entradas</option>
                    <option value="SALIDA">Ver salidas</option>
                </select>
            </div>
            <div class="col-lg-4 col-12 mt-3">
                <label class="form-label" for="fec">Buscar por fecha:</label>
                <input type="date" class="form-control" name="fec" max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-lg-4 col-12 mt-3">
                <label class="form-label" for="suc">Buscar por sucursal: (Obligatorio)</label>
                <?php
                $db = new Database();
                $db->conectarDB();
                $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
                $reg = $db->seleccionar($cadena);
                echo "<div class='me-2'>
                <select name='suc' class='form-select'>
                <option value='0' disabled selected>Seleccionar sucursal...</option>";
                foreach ($reg as $value) 
                {
                    echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
                }
                echo "<option value='999'>VER TODAS</option>";
                echo "</select>
                </div>";
                ?>
            </div>
        </div>
        <div class="container mt-3 d-flex justify-content-center">
            <div class="row mb-3">
                <div class="col-6 col-lg-12">
                    <input class="btn btn-primary" type="submit" value="Buscar" name="MOVIMIENTOS">
                </div>
            </div>
        </div>
    </form>
</div>

  <?php
  if (isset($_POST['MOVIMIENTOS']) && ((isset($_POST['suc']) && $_POST['suc'] != 0)))
  {?>
    <div class="container d-lg-none d-block">
      <h4 align="center">Desliza la tabla para ver toda la informacion</h4>
    </div>
    <?php
    extract($_POST);
    $cadena = "SELECT S.NOMBRE AS 'Sucursal', DATE(ES.FECHA_HORA) AS 'Fecha', ES.INSUMO AS 'Insumo', 
    ES.CANTIDAD AS 'Cantidad', ES.TIPO AS 'Tipo'
    FROM BitacoraEntSal ES
    JOIN SUCURSALES S ON S.ID_SUC = ES.SUCURSAL
    WHERE ES.TIPO = '$mov'";
    if(isset($_POST['suc']) && $_POST['suc'] != 999) {
    $cadena .= "AND ES.SUCURSAL = $suc";}
    if (isset($_POST['fec']) && $_POST['fec'] !== "") {
        $fechaFiltrada = $_POST['fec'];
        $cadena .= " AND DATE(ES.FECHA_HORA) = '$fechaFiltrada'";
      }
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
    <div class="table-responsive">
        <?php
        echo "<table class='table table-hover' id='DetalleMov'>";
        echo "<thead class='table-primary' align='center'>";
        echo "<tr>";
        if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
            echo "<th class='sortable'>Sucursal</th>";
        }
        echo "<th class='col-2 col-lg-3 sortable'>Fecha</th>";
        echo "<th class='col-1 col-lg-1 sortable'>Insumo</th>";
        echo "<th class='col-1 col-lg-1 sortable'>Cantidad</th>";
        echo "<th class='col-1 col-lg-3 sortable'>Tipo</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody align='center'>";
        foreach ($tabla as $registro) {
            echo "<tr>";
            if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
                echo "<td>$registro->Sucursal</td>";
            }
            echo "<td>$registro->Fecha</td>";
            echo "<td>$registro->Insumo</td>";
            echo "<td>$registro->Cantidad</td>";
            echo "<td>$registro->Tipo</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        ?>
    </div>
</div>

  <?php
  echo '<script>saveActiveTab("inventario");</script>';
  }
  else {
  ?>
  <div class="container">
    <h4 align="center">Por favor, selecciona una sucursal primero.</h4>
  </div>
  <?php
  }?>

<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#DetalleMov').DataTable();
    });
  </script>
</body>
</html>