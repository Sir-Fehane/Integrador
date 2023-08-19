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
  <title>Productos</title>
</head>
<body>
<div class="container mt-3">
<div class="btn-group d-flex bg-light" role="group" style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <a class="btn btn-warning flex-fill" href="admin.php">Volver al inicio</a>
    <a class="btn btn-primary flex-fill" href="Inventario.php">Inventario</a>
    <a class="btn btn-primary flex-fill" href="Ordenes.php">Órdenes</a>
    <a class="btn btn-primary flex-fill disabled" href="Productos.php" aria-disabled="true">Productos</a>
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
    echo "<h4 align='center'>Listado de <strong>productos</strong>.";
    echo
    "</h4>"; ?>
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
    $consulta = "SELECT P.CODIGO AS 'ID', P.NOMBRE AS 'Producto', P.TAMANO AS 'Tamaño', 
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
    echo "<th class=' col-lg-3'>Ingredientes</th>"; 
    echo "<th class='col-1 col-lg-1 sortable'>Precio</th>";
    echo "<th class=' col-lg-1'>IMG</th>";
    echo "<th class='col-2 col-lg-1 sortable'>Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody align='center'>";
    foreach ($tabla as $registro) {
        $imgchida = $registro->IMG;
        echo "<tr>";
        echo "<td>$registro->Producto</td>";
        echo "<td>$registro->Tamaño</td>";
        ?>
        <td>
          <select class="form-control w-50">
            <?php
            $db = new Database();
            $db->conectarDB();
            $consulta = "SELECT PI.PI_ID AS 'CODIGOINGR',I.NOMBRE AS 'INGREDIENTE' FROM INVENTARIO I
            JOIN PROD_INV PI ON PI.INGREDIENTE = I.ID_INS
            JOIN PRODUCTOS P ON P.CODIGO = PI.PRODUCTO
            WHERE P.CODIGO = $registro->ID;";
            $reg = $db->seleccionar($consulta);
            foreach ($reg as $row)
            {
              echo "<option value='".$row->CODIGOINGR."' selected disabled>".$row->INGREDIENTE."</option>";
            }
            ?>
          </select>
        </td>
        <?php
        echo "<td>$registro->Precio</td>";
        echo "<td><img src='$imgchida' style='border-radius: 10px;' alt='img' width='50px' height='50px'></td>";
        ?>
        <td class="col-6 col-lg-3">
            <form action="../scripts/Editarprod.php" method="post">
              <input type="hidden" name="COD" value="<?php echo $registro->ID; ?>">
              <input type="hidden" name="nombre" value="<?php echo $registro->Producto; ?>">
              <input type="hidden" name="precio" value="<?php echo $registro->Precio; ?>">
              <input type="hidden" name="IMG" value="<?php echo $registro->IMG; ?>">
              <button type="submit" class="btn btn-sm btn-primary mb-1" name="editarprod">Editar</button>
            </form>
            <form action="../scripts/eliminarproda.php" method="post">
              <input type="hidden" name="COD" value="<?php echo $registro->ID; ?>">
              <button type="submit" class="btn btn-sm btn-danger" name="eliminar" onclick="return confirm('¿Estás seguro que deseas eliminar el producto? Esto se hará en todas las sucursales.')">Borrar</button>
            </form>
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