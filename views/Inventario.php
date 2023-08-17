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
  <title>Inventario</title>
</head>
<body>
<div class="container mt-3">
<div class="btn-group d-flex bg-light" role="group" style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <a class="btn btn-warning flex-fill" href="admin.php">Volver al inicio</a>
    <a class="btn btn-primary flex-fill disabled" href="Inventario.php" aria-disabled="true">Inventario</a>
    <a class="btn btn-primary flex-fill" href="Ordenes.php">Ordenes</a>
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
    echo "<h4 align='center'>Reporte de <strong>inventario</strong> de todas las sucursales ";
    echo
    "</h4>"; ?>
    <h4 align='center'>Selecciona los filtros segun tu necesidad</h4>
    <div class="container">
    <form id="Inventario-form" method="post" action="">
            <div class="row">
                <div class="col-12 col-lg-4 mt-3">
                    <label class="form-label" for="nom">Buscar por nombre:</label>
                    <input type="text" class="form-control" name="nom">
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label class="form-label" for="fec">Buscar por fecha:</label>
                    <input type="date" class="form-control" name="fec" id="fechaInput">
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label class="form-label" for="suc">Buscar por sucursal: (Obligatorio)</label>
                      <?php
                      $db = new Database();
                      $db->conectarDB();
                      $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
                      $reg = $db->seleccionar($cadena);
                      echo "<div class='me-2'>
                      <select name='suc' class='form-select' id='selectSucursal'>
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
                <div class="col-6 col-lg-4 mt-3">
                    <a class="btn btn-primary btn-sm" href="../scripts/NuevoInv.php" role="button">Crear insumo</a>
                </div>
                <div class="col-6 col-lg-4 offset-lg-4 mt-3">
                    <input class="btn btn-primary" type="submit" value="Buscar" name="INVENTARIO">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
  if (isset($_POST['INVENTARIO']) && ((isset($_POST['suc']) && $_POST['suc'] != 0)))
  {
    ?>
    <div class="container d-lg-none d-block">
      <h5 align="center">Desliza la tabla para ver toda la informacion</h5>
    </div>
    <?php
    $valor = 3;
    extract($_POST);
    $cadena = "SELECT INS.SUCURSAL AS 'SUCURSAL', INS.INVENTARIO AS 'ID', S.NOMBRE AS 'Sucursal', I.NOMBRE AS 'Nombre', INS.CANTIDAD AS 'Cantidad', 
    I.PRESENTACION AS 'Presentacion', INS.FECHA AS 'Fecha'
        FROM INVENTARIO I
        INNER JOIN INV_SUC INS ON I.ID_INS = INS.INVENTARIO
        INNER JOIN SUCURSALES S ON INS.SUCURSAL = S.ID_SUC
        WHERE INS.ESTADO = 'ACTIVO'";
        if(isset($_POST['nom'])) {
          $cadena .= "AND I.NOMBRE like '%$nom%'";
        }
        if(isset($_POST['suc']) && $_POST['suc'] != 999) {
          $cadena .= "AND INS.SUCURSAL = $suc";
        }
        if (isset($_POST['fec']) && $_POST['fec'] !== "") {
          $fechaFiltrada = $_POST['fec'];
          $cadena .= " AND INS.FECHA = '$fechaFiltrada'";
        }
        $cadena .= " ORDER BY INS.FECHA DESC";
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
      <div class="table-responsive">
        <?php
    echo "<table class='table table-hover ml-3' id='DetalleInv' align='center'> ";
    echo "<thead class='table-primary' align='center'>";
    echo "<tr>";
    if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
      $valor = 4;
        echo "<th class='col-3 col-lg-2 sortable'>Sucursal</th>";
    }
    echo "<th class='col-3 col-lg-3 sortable'>Nombre</th>";
    echo "<th class='col-1 col-lg-1 sortable'>Cantidad</th>";
    echo "<th class='col-1 col-lg-2 sortable'>Presentacion</th>";
    echo "<th class='col-3 col-lg-3 sortable'>Fecha</th>";
    echo "<th class='col-2 col-lg-1 sortable'>Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody align='center'>";
    foreach ($tabla as $registro) {
        echo "<tr>";
        if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
            echo "<td>$registro->Sucursal</td>";
        }
        echo "<td>$registro->Nombre</td>";
        echo "<td>$registro->Cantidad</td>";
        echo "<td>$registro->Presentacion</td>";
        echo "<td>$registro->Fecha</td>";
        ?>
        <td>
            <form action="../scripts/EditarInv.php" method="post">
                <input type="hidden" name="idinv" value="<?php echo $registro->ID; ?>">
                <input type="hidden" name="nombre" value="<?php echo $registro->Nombre; ?>">
                <input type="hidden" name="existencia" value="<?php echo $registro->Cantidad; ?>">
                <input type="hidden" name="fecha" value="<?php echo $registro->Fecha; ?>">
                <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
            </form>
            <form action="../scripts/EliminarInv.php" method="post">
              <input type="hidden" name="idinv" value="<?php echo $registro->ID; ?>">
              <input type="hidden" name="idsuc" value="<?php echo $registro->SUCURSAL; ?>">
              <button type="submit" class="btn btn-sm btn-danger" name="eliminar" onclick="return confirm('¿Estás seguro que deseas eliminar el insumo?')">Borrar</button>
            </form>
        </td>
        <?php
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    ?>
      </div>
    
</div>
  <?php
  }
  else {
  ?>
  <div class="container">
    <h4 align="center">Por favor, selecciona una sucursal primero.</h4>
  </div>
  <?php
  }?>
  <script>
    var fechaInput = document.getElementById('fechaInput');
    var fechaActual = new Date().toISOString().split('T')[0];
    fechaInput.max = fechaActual;
</script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#DetalleInv').DataTable({
        "order": [[<?php echo $valor; ?>, 'desc']]
    });
});
  </script>
</body>
</html>