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
  <title>Productos</title>
</head>
<body>
<?php
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB();
    echo "<h6 align='center'>Listado de <strong>productos</strong>";
    echo
    "</h6>"; ?>
<?php
$db = new Database();
$db->conectarDB();
?>
<br>
<div class="d-flex justify-content-center">
  <a class="btn btn-primary mb-3" href="../scripts/NuevoProd.php" role="button">Añadir un nuevo producto</a>
</div>
<div class="container d-lg-none d-block">
  <h6 align="center">Desliza la tabla para ver toda la informacion</h6>
</div>
<?php
    $consulta = "SELECT P.CODIGO, P.NOMBRE AS 'Producto', P.TAMANO AS 'Tamaño', P.DESCRIPCION AS 'Descripcion', 
    P.PRECIO AS 'Precio', P.img_prod as 'IMG' FROM PRODUCTOS P
    WHERE P.ESTADO = 'ACTIVO'";
    $tabla = $db->seleccionar($consulta);
    ?>
    <div class="container-fluid justify-content-center mr-3">
      <div class="table-responsive">
        <?php
    echo "<table class='table table-hover' id='DetallePro'>";
    echo "<thead class='table-primary' align='center'>";
    echo "<tr>";
    echo "<th class='col-5 col-lg-3 sortable'>Producto</th>";
    echo "<th class='col-4 col-lg-3 sortable'>Tamaño</th>";
    echo "<th class=' col-lg-3'>Descripcion</th>"; 
    echo "<th class='col-1 col-lg-3 sortable'>Precio</th>";
    echo "<th class=' col-lg-3 d-none d-lg-table-cell'>IMG</th>";
    echo "<th class='col-2 col-lg-3 sortable'>Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody align='center'>";
    foreach ($tabla as $registro) {
        $imgchida = $registro->IMG;
        echo "<tr>";
        echo "<td>$registro->Producto</td>";
        echo "<td>$registro->Tamaño</td>";
        echo "<td>$registro->Descripcion</td>";
        echo "<td>$registro->Precio</td>";
        echo "<td><img src='$imgchida' style='border-radius: 10px;' alt='img' width='50px' height='50px'></td>";
        ?>
        <td class="col-6 col-lg-3">
            <form action="../scripts/EditarProd.php" method="post">
        <input type="hidden" name="COD" value="<?php echo $registro->CODIGO; ?>">
        <input type="hidden" name="PROD" value="<?php echo $registro->Producto; ?>">
        <input type="hidden" name="TAM" value="<?php echo $registro->Tamaño; ?>">
        <input type="hidden" name="DES" value="<?php echo $registro->Descripcion; ?>">
        <input type="hidden" name="PRE" value="<?php echo $registro->Precio; ?>">
        <input type="hidden" name="IMG" value="<?php echo $registro->IMG; ?>">
        <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
            </form>
            <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal"
                    data-bs-target="#borrarprod">Borrar</button>
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
<!-- ELIMINAR -->
<div class="modal fade" id="borrarprod" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="borrarper" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estas seguro de eliminar este producto?</p> <br>
        <p>Si lo haces<strong>, no se podra recuperar.</strong></p>
      </div>
      <div class="modal-footer">
      <form action="../scripts/eliminarproda.php" method="post">
          <input type="hidden" name="COD" value="<?php echo $registro->CODIGO; ?>">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger" name="eliminar">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#DetallePro').DataTable();
    });
  </script>

</body>
</html>