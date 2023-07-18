<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <title>Inventario</title>
</head>
<body>
<?php
if (isset($_POST['sucursal'])) 
{
  $db = new Database();
  $db->conectarDB();
  $sucursalId = $_POST['sucursal'];
  if ($sucursalId != 0 && $sucursalId != 999) {
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
<div class="d-flex justify-content-center">
<a class="btn btn-primary mb-3" href="../scripts/NuevoInv.php">Añadir nuevo insumo</a>

</div>
<?php
}
if (isset($_POST['sucursal']) && $_POST['sucursal'] != 0) {
  $sucursalId = $_POST['sucursal'];
  if ($sucursalId != 0 && $sucursalId != 999) {
    $consulta = "SELECT INS.INVENTARIO AS 'ID', S.NOMBRE AS 'Sucursal', I.NOMBRE AS 'Nombre', INS.CANTIDAD AS 'Cantidad', I.PRESENTACION AS 'Presentacion', INS.FECHA AS 'Fecha'
    FROM INVENTARIO I
    INNER JOIN INV_SUC INS ON I.ID_INS = INS.INVENTARIO
    INNER JOIN SUCURSALES S ON INS.SUCURSAL = S.ID_SUC
    WHERE ID_SUC = $sucursalId
    AND I.ESTADO = 'ACTIVO';
    ORDER BY S.ID_SUC,I.NOMBRE;";
    $tabla = $db->seleccionar($consulta);
  } elseif ($sucursalId == 999) {
    $consulta = "SELECT INS.INVENTARIO AS 'ID', S.NOMBRE AS 'Sucursal', I.NOMBRE AS 'Nombre', INS.CANTIDAD AS 'Cantidad', I.PRESENTACION AS 'Presentacion', INS.FECHA AS 'Fecha'
    FROM INVENTARIO I
    INNER JOIN INV_SUC INS ON I.ID_INS = INS.INVENTARIO
    INNER JOIN SUCURSALES S ON INS.SUCURSAL = S.ID_SUC
    WHERE I.ESTADO = 'ACTIVO'
    ORDER BY S.ID_SUC,I.NOMBRE;";
    $tabla = $db->seleccionar($consulta);
  }

  echo "<table class='table table-hover tabla-xs' id='tabla'>";
  echo "<thead class='table-primary' align='center'>";
  echo "<tr>";
  echo "<th class='d-none'>ID</th>";
  if ($sucursalId == 999) {
    echo "<th>Sucursal</th>";
  }
  echo "<th class='col-2 col-lg-3'>Nombre</th>";
  echo "<th class='col-1 col-lg-1'>Cantidad</th>";
  if($sucursalId != 999)
  {
    echo "<th class='col-1 col-lg-1'>Presentacion</th>";
  }
  echo "<th class='col-1 col-lg-3 d-lg-table-cell d-none'>Fecha de recepcion</th>";
  echo "<th class='col-2 col-lg-4'>Editar</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody align='center'>";
  foreach ($tabla as $registro) {
    echo "<tr>";
    echo "<td style='display: none'>$registro->ID</td>";
    if ($sucursalId == 999) {
      echo "<td>$registro->Sucursal</td>";
    }
    echo "<td>$registro->Nombre</td>";
    echo "<td>$registro->Cantidad</td>";
    if ($sucursalId != 999){
      echo "<td>$registro->Presentacion</td>";
    }
    echo "<td class='d-lg-table-cell d-none'>$registro->Fecha</td>";
    ?>
    <td align="">
      <form action="../scripts/EditarInv.php" method="post">
        <input type="hidden" name="id" value="<?php echo $registro->ID; ?>">
        <input type="hidden" name="nombre" value="<?php echo $registro->Nombre; ?>">
        <input type="hidden" name="existencia" value="<?php echo $registro->Cantidad; ?>">
        <input type="hidden" name="fecha" value="<?php echo $registro->Fecha; ?>">
        <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
      </form>
      <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#borrarinv">Borrar</button>
    </td>
    <?php
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
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>