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
  <title>Empleados</title>
</head>
<body>
<?php
$db = new Database();
$db->conectarDB();
?>
<br>
<div class="d-flex justify-content-center">
  <a class="btn btn-primary mb-3" href="../scripts/NuevoProd.php" role="button">Añadir un nuevo producto</a>
</div>
<?php


    $consulta = "SELECT P.CODIGO, P.NOMBRE AS 'PRODUCTO', P.TAMANO AS 'TAMAÑO', P.DESCRIPCION AS 'DESCRIPCION', P.PRECIO AS 'PRECIO', P.img_prod as 'img' FROM PRODUCTOS P
    WHERE P.ESTADO = 'ACTIVO'";
    $tabla = $db->seleccionar($consulta);
    
  echo "<table class='table table-hover' id='tabla'>";
  echo "<thead class='table-primary' align='center'>";
  echo "<tr>";
  echo "<th class='col-1 col-lg-1' style='display: none'>CODIGO</th>";
  echo "<th class='col-2 t'>PRODUCTO</th>";
  echo "<th class='col-2'>TAMAÑO</th>";
  echo "<th class='col-2'>DESCRIPCION</th>";
  echo "<th class='col-2'>PRECIO</th>";
  echo "<th class='col-2'>IMG</th>";
  echo "<th class='col-2'>EDITAR</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody align='center'>";
  foreach ($tabla as $registro) {
    $imgchida = $registro->img;
    echo "<tr>";
    echo "<td style='display: none'>$registro->CODIGO</td>";
      echo"<td>$registro->PRODUCTO</td>";
    echo "<td>$registro->TAMAÑO</td>";  
      echo "<td>$registro->DESCRIPCION</td>"; 
    echo "<td>$registro->PRECIO</td>";
    echo "<td> <img src='$imgchida' style='border-radius: 10px;' alt='img'width= '50px'
                     height=' 50px'> </td>";;
    ?>
    <td>
    <form action="../scripts/Editarprod.php" method="post">
        <input type="hidden" name="COD" value="<?php echo $registro->CODIGO; ?>">
        <input type="hidden" name="PROD" value="<?php echo $registro->PRODUCTO; ?>">
        <input type="hidden" name="TAM" value="<?php echo $registro->TAMANÑO; ?>">
        <input type="hidden" name="DES" value="<?php echo $registro->DESCRIPCION; ?>">
        <input type="hidden" name="PRE" value="<?php echo $registro->PRECIO; ?>">
        <input type="hidden" name="IMG" value="<?php echo $registro->img_prod; ?>">
        <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
      </form>
      <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#borrarprod">Borrar</button>
    </td>
    <?php
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";


$db->desconectarDB();
?>
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
</body>
</html>