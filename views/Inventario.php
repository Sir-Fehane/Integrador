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
    echo "<h6 align='center'>Reporte de <strong>inventario</strong> de todas las sucursales ";
    echo
    "</h6>"; ?>
    <h6 align='center'>Selecciona los filtros segun tu necesidad</h6>
    <div class="container">
    <form class="" method="post">
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
                      $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
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
      <h6 align="center">Desliza la tabla para ver toda la informacion</h6>
    </div>
    <?php
    extract($_POST);
    $cadena = "SELECT INS.INVENTARIO AS 'ID', S.NOMBRE AS 'Sucursal', I.NOMBRE AS 'Nombre', INS.CANTIDAD AS 'Cantidad', 
    I.PRESENTACION AS 'Presentacion', INS.FECHA AS 'Fecha'
        FROM INVENTARIO I
        INNER JOIN INV_SUC INS ON I.ID_INS = INS.INVENTARIO
        INNER JOIN SUCURSALES S ON INS.SUCURSAL = S.ID_SUC
        WHERE I.ESTADO = 'ACTIVO'";
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
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
      <div class="table-responsive">
        <?php
    echo "<table class='table table-hover ml-3' id='DetalleInv'>";
    echo "<thead class='table-primary' align='center'>";
    echo "<tr>";
    if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
        echo "<th class='col-3 col-lg-2 sortable'>Sucursal</th>";
    }
    echo "<th class='col-3 col-lg-3 sortable'>Nombre</th>";
    echo "<th class='col-1 col-lg-2 sortable'>Cantidad</th>";
    echo "<th class='col-3 col-lg-4 sortable'>Fecha</th>";
    echo "<th class='col-2 col-lg-3'>Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody align='center'>";
    foreach ($tabla as $registro) {
        echo "<tr>";
        if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
            echo "<td class='col-3 col-lg-2'>$registro->Sucursal</td>";
        }
        echo "<td>$registro->Nombre</td>";
        echo "<td>$registro->Cantidad</td>";
        echo "<td class='col-lg-4'>$registro->Fecha</td>";
        ?>
        <td class="col-2 col-lg-3 w-50">
            <form action="../scripts/EditarInv.php" method="post">
                <input type="hidden" name="id" value="<?php echo $registro->ID; ?>">
                <input type="hidden" name="nombre" value="<?php echo $registro->Nombre; ?>">
                <input type="hidden" name="existencia" value="<?php echo $registro->Cantidad; ?>">
                <input type="hidden" name="fecha" value="<?php echo $registro->Fecha; ?>">
                <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
            </form>
            <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal"
                    data-bs-target="#borrarinv">Borrar</button>
        </td>
        <?php
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    ?>
      </div>
    
</div>

  <!-- ELIMINAR -->
<div class="modal fade" id="borrarinv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="borrarinv" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estas seguro que deseas eliminar este material?</p> <br>
        <p>Si lo haces<strong>, no se podra recuperar.</strong></p>
      </div>
      <div class="modal-footer">
        <form action="../scripts/EliminarInv.php" method="post">
          <input type="hidden" name="id" value="<?php echo $registro->ID; ?>">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger" name="eliminar">Eliminar</button>
        </form>
      </div>
    </div>
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
  <script>
    // Obtener el elemento de entrada de fecha por su ID
    var fechaInput = document.getElementById('fechaInput');

    // Obtener la fecha actual en el formato de fecha de entrada (YYYY-MM-DD)
    var fechaActual = new Date().toISOString().split('T')[0];
    
    // Establecer el valor mínimo del campo de entrada de fecha como la fecha actual
    fechaInput.max = fechaActual;
</script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#DetalleInv').DataTable();
    });
  </script>
</body>
</html>