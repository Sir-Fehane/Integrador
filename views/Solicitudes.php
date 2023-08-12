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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <title>Inventario</title>
</head>
<body>
<?php
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB();
    echo "<h6 align='center'>Reporte de <strong>solicitudes</strong> de todas las sucursales ";
    echo
    "</h6>"; ?>
    <h6 align='center'>Selecciona los filtros segun tu necesidad</h6>
    <div class="container">
    <form class="" method="post">
        <div class="row">
            <div class="col-md-4 mt-3">
                <label class="form-label" for="sol">Buscar por estado:</label>
                <select name="sol" class="form-select">
                    <option value="solicitado">Ver solicitadas</option>
                    <option value="recibido">Ver recibidas</option>
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
            <input class="btn btn-primary" type="submit" value="Buscar" name="SOLICITUDES">
        </div>
    </form>
</div>
  <?php
  if (isset($_POST['SOLICITUDES']) && ((isset($_POST['suc']) && $_POST['suc'] != 0)))
  {?>
    <div class="container d-lg-none d-block">
      <h6 align="center">Desliza la tabla para ver toda la informacion</h6>
    </div>
    <?php
    extract($_POST);
    $cadena = "SELECT SU.NOMBRE AS 'Sucursal',I.NOMBRE AS 'Insumo',DS.CANTIDAD AS 'Cantidad',
    S.FECHA AS 'Fecha', S.ESTADO AS 'Estado'
    FROM SOLICITUDES S
    INNER JOIN DETALLE_SOLICITUD DS ON DS.SOLICITUD = S.ID_SOLICITUD
    INNER JOIN SUCURSALES SU ON SU.ID_SUC = S.SUCURSAL
    INNER JOIN INVENTARIO I ON I.ID_INS = DS.INVENTARIO 
        WHERE S.ESTADO = '$sol'";
        if(isset($_POST['suc']) && $_POST['suc'] != 999) {
          $cadena .= "AND S.SUCURSAL = $suc";
        }
        if (isset($_POST['fec']) && $_POST['fec'] !== "") {
          $fechaFiltrada = $_POST['fec'];
          $cadena .= " AND S.FECHA = '$fechaFiltrada'";
        }
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
    <div class="table-responsive">
        <table class='table table-hover' id='DetalleSol'>
            <thead class='table-primary' align='center'>
                <tr>
                    <?php
                    if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
                        echo "<th class='sortable'>Sucursal</th>";
                    }
                    ?>
                    <th class='col-2 col-lg-3 sortable'>Insumo</th>
                    <th class='col-1 col-lg-1 sortable'>Cantidad</th>
                    <th class='col-1 col-lg-1 sortable'>Fecha</th>
                    <th class='col-1 col-lg-3 sortable'>Estado</th>
                </tr>
            </thead>
            <tbody align='center'>
                <?php
                foreach ($tabla as $registro) {
                    echo "<tr>";
                    if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
                        echo "<td>$registro->Sucursal</td>";
                    }
                    echo "<td>$registro->Insumo</td>";
                    echo "<td>$registro->Cantidad</td>";
                    echo "<td>$registro->Fecha</td>";
                    echo "<td>$registro->Estado</td>";
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
      $('#DetalleSol').DataTable();
    });
  </script>
</body>
</html>