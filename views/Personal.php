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
  <title>Personal</title>
</head>
<body>
<?php
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB();
    echo "<h6 align='center'>Reporte de <strong>personal</strong> de todas las sucursales ";
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
                <label class="form-label" for="pue">Buscar por puesto:</label>
                <select name="pue" class="form-select">
                    <option value="0">Selecciona...</option>
                    <option value="EMP GENERAL">EMPLEADO GENERAL</option>
                    <option value="ENCARGADO">ENCARGADO</option>
                    <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                </select>
            </div>
            <div class="col-12 col-lg-4 mt-3">
                <label class="form-label" for="suc">Buscar por sucursal: (Obligatorio)</label>
                <?php
                $db = new Database();
                $db->conectarDB();
                $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
                $reg = $db->seleccionar($cadena);
                echo "<div class='me-2'>
                <select name='suc' class='form-select'>
                    <option value='0' disabled selected>Seleccionar sucursal...</option>";
                foreach ($reg as $value) {
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
                    <a class="btn btn-primary btn-sm" href="../scripts/NuevoEmp.php" role="button">Nuevo empleado</a>
                </div>
                <div class="col-6 col-lg-4 offset-lg-4 mt-3">
                    <input class="btn btn-primary" type="submit" value="Buscar" name="EMPLEADOS">
                </div>
            </div>
        </div>
    </form>
</div>

  <?php
  if (isset($_POST['EMPLEADOS']) && ((isset($_POST['suc']) && $_POST['suc'] != 0)))
  {?>
    <div class="container d-lg-none d-block">
      <h6 align="center">Desliza la tabla para ver toda la informacion</h6>
    </div>
    <?php
    extract($_POST);
    $cadena = "SELECT  ES.EMPLEADO AS 'IDEMP', 
    S.NOMBRE AS 'Sucursal', 
    U.NOMBRE AS 'Empleado', 
    U.DIRECCION AS 'Direccion', 
    ES.PUESTO AS 'Puesto', 
    U.CORREO AS 'Correo',
    U.TELEFONO AS 'Telefono' FROM USUARIOS U
    INNER JOIN EMPLEADO_SUCURSAL ES ON U.ID_USUARIO = ES.EMPLEADO
    INNER JOIN SUCURSALES S ON S.ID_SUC = ES.SUCURSAL
    WHERE U.ROL = 3 AND
    ES.ESTADO = 'ACTIVO'";
    if(isset($_POST['nom']) && $_POST['nom'] != '') {
      $cadena .= "AND U.NOMBRE like '%$nom%'";
    }
    if(isset($_POST['suc']) && $_POST['suc'] != 999) {
      $cadena .= "AND ES.SUCURSAL = $suc";
    }
    if(isset($_POST['pue']) && $_POST['pue'] != '0') {
      $cadena .= "AND ES.PUESTO = '$pue'";
    }
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
    <div class="table-responsive">
        <?php
        echo "<table class='table table-hover' id='DetalleInv'>";
        echo "<thead class='table-primary' align='center'>";
        echo "<tr>";
        echo "<th class='d-none'>ID</th>";
        if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
            echo "<th class='sortable'>Sucursal</th>";
        }
        echo "<th class='col-2 col-lg-3 sortable'>Empleado</th>";
        echo "<th class='col-1 col-lg-1 sortable'>Direccion</th>";
        echo "<th class='col-1 col-lg-1 sortable'>Puesto</th>";
        echo "<th class='col-1 col-lg-1 d-none d-lg-table-cell sortable'>Correo</th>"; // Oculta en móviles
        echo "<th class='col-1 col-lg-1 sortable'>Telefono</th>";
        echo "<th class='col-2 col-lg-4 sortable'>Editar</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody align='center'>";
        foreach ($tabla as $registro) {
            echo "<tr>";
            echo "<td style='display: none'>$registro->IDEMP</td>";
            if (isset($_POST['suc']) && ($_POST['suc'] == 999 || $_POST['suc'] == 0)) {
                echo "<td>$registro->Sucursal</td>";
            }
            echo "<td>$registro->Empleado</td>";
            echo "<td>$registro->Direccion</td>";
            echo "<td>$registro->Puesto</td>";
            echo "<td class='d-none d-lg-table-cell'>$registro->Correo</td>"; // Oculta en móviles
            echo "<td>$registro->Telefono</td>";
            ?>
            <td class="d-flex justify-content-center">
                <form action="../scripts/EditarEmp.php" method="post">
                    <input type="hidden" name="idemp" value="<?php echo $registro->IDEMP; ?>">
                    <input type="hidden" name="nombre" value="<?php echo $registro->Empleado; ?>">
                    <input type="hidden" name="direccion" value="<?php echo $registro->Direccion; ?>">
                    <input type="hidden" name="cor" value="<?php echo $registro->Correo; ?>">
                    <input type="hidden" name="tel" value="<?php echo $registro->Telefono; ?>">
                    <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
                </form>
                <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#borraremp">Borrar</button>
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
<div class="modal fade" id="borraremp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="borrarinv" aria-hidden="true">
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
        <form action="../scripts/EliminarEmp.php" method="post">
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