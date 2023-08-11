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
    echo "<h6 align='center'>Reporte de <strong>cierre de turno</strong> de todas las sucursales ";
    echo
    "</h6>"; ?>
    <h6 align='center'>Selecciona los filtros segun tu necesidad</h6>
    <div class="container">
    <form class="" method="post">
      <div class="container d-flex">
        <div class="container mt-3">
          <label class="form-label" for="fec">Buscar con fecha:</label>
          <input type="date" class="form-control" name="fec"  max="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="container mt-3">
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
      <div class="container mt-3 justify-content-center d-flex">
        <input class="btn btn-primary" type="submit" value="Buscar" name="CIERRES">
      </div>
    </form>
  </div>
  <?php
        if (isset($_POST['CIERRES']) && ((isset($_POST['suc']) && $_POST['suc'] != 0)))
        {
          extract($_POST);
          $cadena = "SELECT S.NOMBRE AS 'Sucursal', BC.FECHA AS 'Fecha', BC.INSUMO AS 'Insumo', 
      BC.CANTIDAD_ANTERIOR AS 'Inventario_Inicial', BC.CANTIDAD_NUEVA AS 'Inventario_Final',
      BC.CANTIDAD_NUEVA - BC.CANTIDAD_ANTERIOR AS 'Diferencia'
      FROM BitacoraCierre BC
      INNER JOIN SUCURSALES S ON S.ID_SUC = BC.Sucursal";

      if ($suc != 999) {
          $cadena .= " WHERE BC.SUCURSAL = $suc";
      }

      if (isset($_POST['fec']) && $_POST['fec'] !== "") {
          $fechaFiltrada = $_POST['fec'];
          if ($suc != 999) {
              $cadena .= " AND BC.FECHA = '$fechaFiltrada'";
          } else {
              $cadena .= " WHERE BC.FECHA = '$fechaFiltrada'";
          }
      }

      if(isset($_POST['nom'])) {
          $nom = $_POST['nom'];
          if ($suc != 999 || (isset($_POST['fec']) && $_POST['fec'] !== "")) {
              $cadena .= " AND BC.INSUMO like '%$nom%'";
          } else {
              $cadena .= " WHERE BC.INSUMO like '%$nom%'";
          }
      }

      $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container w-75 justify-content-center">
    <?php
  echo "<table class='table table-hover' id='DetalleCie'>";
  echo "<thead class='table-primary' align='center'>";
  echo "<tr>";
  if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
  echo "<th class='sortable'>Sucursal</th>";}
  echo "<th class='col-2 col-lg-3 sortable'>Fecha</th>";
  echo "<th class='col-2 col-lg-3 sortable'>Insumo</th>";
  echo "<th class='col-1 col-lg-1 sortable'>Inventario_Inicial</th>";
  echo "<th class='col-1 col-lg-1 sortable'>Inventario_Final</th>";
  echo "<th class='col-1 col-lg-3 sortable'>Diferencia</th>";
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
    echo "<td>$registro->Inventario_Inicial</td>";
    echo "<td>$registro->Inventario_Final</td>";
    echo "<td>$registro->Diferencia</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
    ?>
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
      $('#DetalleCie').DataTable();
    });
  </script>
</body>
</html>