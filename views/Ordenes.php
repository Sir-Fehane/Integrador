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
  <title>Ordenes</title>
</head>
<body>
<div class="container mt-3">
<div class="btn-group d-flex bg-light" role="group" style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <a class="btn btn-warning flex-fill" href="admin.php">Volver al inicio</a>
    <a class="btn btn-primary flex-fill" href="Inventario.php">Inventario</a>
    <a class="btn btn-primary flex-fill disabled" href="Ordenes.php" aria-disabled="true">Ordenes</a>
    <a class="btn btn-primary flex-fill" href="Productos.php">Productos</a>
    <a class="btn btn-primary flex-fill" href="Sucursales.php">Sucursales</a>
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
    echo "<h4 align='center'>Reporte de <strong>ordenes</strong> de todas las sucursales ";
    echo
    "</h4>"; ?>
    <h4 align='center'>Selecciona los filtros segun tu necesidad</h4>
    <div class="container">
    <form class="" method="post">
        <div class="row">
            <div class="col-md-4 mt-3">
                <label class="form-label" for="est">Buscar por estado:</label>
                <select name="est" class="form-select">
                    <option value="ENTREGADA">Ver entregadas</option>
                    <option value="CANCELADA">Ver canceladas</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label class="form-label" for="fec">Buscar por fecha:</label>
                <input type="date" class="form-control" name="fec" max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-md-4 mt-3">
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
        <div class="mt-3 justify-content-center d-flex">
            <input class="btn btn-primary" type="submit" value="Buscar" name="ORDENES">
        </div>
    </form>
</div>
  <?php
  if (isset($_POST['ORDENES']) && ((isset($_POST['suc']) && $_POST['suc'] != 0)))
  {?>
    <div class="container d-lg-none d-block">
      <h6 align="center">Desliza la tabla para ver toda la informacion</h6>
    </div>
    <?php
    $valor = 3;
    extract($_POST);
    $cadena = "SELECT OV.NO_ORDEN AS 'Numero', S.NOMBRE AS 'Sucursal', U.NOMBRE AS 'Cliente', CONCAT(P.NOMBRE,' ', P.TAMANO) AS 'Producto',
    DEO.CANTIDAD AS 'Cantidad', OV.TOTAL AS 'Total', OV.HORA_FECHA AS 'Fecha', OV.ESTADO AS 'Estado'
    FROM ORDEN_VENTA OV
    JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
    JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
    JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
    JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
    WHERE OV.ESTADO = '$est'";
        if(isset($_POST['suc']) && $_POST['suc'] != 999) {
          $cadena .= "AND S.ID_SUC = $suc";
        }
        if (isset($_POST['fec']) && $_POST['fec'] !== "") {
          $fechaFiltrada = $_POST['fec'];
          $cadena .= "AND DATE(OV.HORA_FECHA) = '$fechaFiltrada'";
        }
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
    <div class="table-responsive">
        <table class='table table-hover' id='DetalleOrd'>
            <thead class='table-primary' align='center'>
                <tr>
                <th class='col-2 col-lg-1 sortable'>Numero</th>
                    <?php
                    if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
                    $valor = 4;
                    echo "<th class='col-1 col-lg-2 sortable'>Sucursal</th>";
                    }
                    ?>
                    <th class='col-2 col-lg-2 sortable'>Cliente</th>
                    <th class='col-2 col-lg-2 sortable'>Total</th>
                    <th class='col-2 col-lg-3 sortable'>Fecha</th>
                    <th class='col-2 col-lg-2 sortable'>Estado</th>
                    <th class="col-1 col-lg-2">Detalles</th>
                </tr>
            </thead>
            <tbody align='center'>
                <?php
                foreach ($tabla as $registro) {
                    echo "<tr>";
                    echo "<td>$registro->Numero</td>";
                    if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
                        echo "<td>$registro->Sucursal</td>";
                    }
                    echo "<td>$registro->Cliente</td>";
                    echo "<td>$registro->Total</td>";
                    echo "<td>$registro->Fecha</td>";
                    echo "<td>$registro->Estado</td>";
                    ?>
                    <td>
                      <form method="post" action="../scripts/DetalleOrdenes.php">
                        <input type="hidden" name="num" value="<?php echo $registro->Numero; ?>">
                        <button type="submit" class="btn btn-sm btn-primary">Ver detalle</button>
                      </form>
                    </td>
                    <?php
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
  <?php
  }
  else {
  ?>
  <div class="container">
    <h6 align="center">Por favor, selecciona una sucursal primero.</h6>
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
    $('#DetalleOrd').DataTable({
        "order": [[<?php echo $valor; ?>, 'desc']]
    });
});
  </script>
</body>
</html>