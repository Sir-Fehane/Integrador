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
  <title>Empleados</title>
</head>
<body>
<?php
$db = new Database();
$db->conectarDB();
if (isset($_POST['sucursal'])) 
{
  $sucursalId = $_POST['sucursal'];
  if ($sucursalId != 0 && $sucursalId != 999) {
    $consulta = "SELECT NOMBRE FROM SUCURSALES WHERE ID_SUC = $sucursalId";
    $sucursal = $db->seleccionar($consulta);
    $Nombre = $sucursal[0]->NOMBRE;
    echo "<h2>Sucursal $Nombre</h2>";
  }
if ($sucursalId == 0)
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
  <a class="btn btn-primary mb-3" href="../scripts/NuevoEmp.php" role="button">Añadir nuevo empleado</a>
</div>
<?php
}
if (isset($_POST['sucursal']) && $_POST['sucursal'] != 0) {
  $sucursalId = $_POST['sucursal'];
  if ($sucursalId != 0 && $sucursalId != 999) {
    $consulta = "SELECT U.DIRECCION AS 'Direccion', ES.EMPLEADO AS 'ID', U.NOMBRE AS 'Empleado', ES.PUESTO AS 'Puesto',U.TELEFONO AS 'Telefono' FROM USUARIOS U
    INNER JOIN EMPLEADO_SUCURSAL ES ON U.ID_USUARIO = ES.EMPLEADO
    INNER JOIN SUCURSALES S ON S.ID_SUC = ES.SUCURSAL
    WHERE U.ROL = 3 AND
    ES.ESTADO = 'ACTIVO' AND
    ID_SUC = $sucursalId;";
    $tabla = $db->seleccionar($consulta);
  } elseif ($sucursalId == 999) {
    $consulta = "SELECT U.DIRECCION AS 'Direccion', ES.EMPLEADO AS 'ID', S.NOMBRE AS 'Sucursal', U.NOMBRE AS 'Empleado', ES.PUESTO AS 'Puesto',U.TELEFONO AS 'Telefono' FROM USUARIOS U
    INNER JOIN EMPLEADO_SUCURSAL ES ON U.ID_USUARIO = ES.EMPLEADO
    INNER JOIN SUCURSALES S ON S.ID_SUC = ES.SUCURSAL
    WHERE U.ROL = 3 AND
    ES.ESTADO = 'ACTIVO'";
    $tabla = $db->seleccionar($consulta);
  }

  echo "<table class='table table-hover' id='tabla'>";
  echo "<thead class='table-primary' align='center'>";
  echo "<tr>";
  echo "<th class='col-1 col-lg-1' style='display: none'>ID</th>";
  echo "<th class='col-1 col-lg-1' style='display: none'>Direccion</th>";
  if ($sucursalId == 999) {
    echo "<th>Sucursal</th>";
  }
  echo "<th class='col-3 t'>Empleado</th>";
  if($sucursalId != 999){
      echo "<th class='col-2'>Puesto</th>";
  }
  echo "<th class='col-4'>Telefono</th>";
  echo "<th class='col-3'>Editar</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody align='center'>";
  foreach ($tabla as $registro) {
    echo "<tr>";
    echo "<td style='display: none'>$registro->ID</td>";
    echo "<td style='display: none'>$registro->Direccion</td>";
    if ($sucursalId == 999) {
      echo "<td>$registro->Sucursal</td>";
    }
    echo "<td>$registro->Empleado</td>";
    if($sucursalId != 999){
      echo "<td>$registro->Puesto</td>";
    }
    echo "<td>$registro->Telefono</td>";
    ?>
    <td>
    <form action="../scripts/EditarEmp.php" method="post">
        <input type="hidden" name="id" value="<?php echo $registro->ID; ?>">
        <input type="hidden" name="nombre" value="<?php echo $registro->Empleado; ?>">
        <input type="hidden" name="direccion" value="<?php echo $registro->Direccion; ?>">
        <input type="hidden" name="tel" value="<?php echo $registro->Telefono; ?>">
        <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
      </form>
      <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#borraremp">Borrar</button>
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
$db->desconectarDB();
?>
<!-- ELIMINAR -->
<div class="modal fade" id="borrarper" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="borrarper" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estas seguro que deseas dar de baja al empleado?</p> <br>
        <p>Si lo haces<strong>, no se podra recuperar.</strong></p>
      </div>
      <div class="modal-footer">
      <form action="../scripts/EliminarEmp.php" method="post">
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