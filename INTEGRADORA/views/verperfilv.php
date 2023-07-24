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
session_start();
include '../class/database.php';
$db = new Database();
$db->conectarDB();
  $usuario1 = $_SESSION['usuario'];
    echo "<h2 align ='center' >Perfil</h2>";
?>
<?php
    $consulta1 = "SELECT U.ID_USUARIO AS ID, U.NOMBRE AS 'NOMBRE', U.DIRECCION AS 'DIRECCION', U.TELEFONO AS 'TELEFONO', U.CORREO AS 'CORREO'
    FROM USUARIOS U
    WHERE NOMBRE = '$usuario1';";
    $tabla = $db->seleccionar($consulta1);

    echo "<table class='table table-hover tabla-xs' id='tabla'>";
    echo "<thead class='table-primary' align='center'>";
    echo "<tr>";
    echo "<th class='d-none'>ID</th>";
   echo "<th>NOMBRE</th>";
    echo "<th class='col-2 col-lg-3'>DIRECCION</th>";
    echo "<th class='col-1 col-lg-1'>TELEFONO</th>";
   echo "<th class='col-1 col-lg-1'>CORREO</th>";
   echo "<th class='col-1 col-lg-2'> Editar</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody align='center'>";
    foreach ($tabla as $registro) {
      echo "<tr>";
      echo "<td style='display: none'>$registro->ID</td>";
        echo "<td>$registro->NOMBRE</td>";
      echo "<td>$registro->DIRECCION</td>";
      echo "<td>$registro->TELEFONO</td>";
        echo "<td>$registro->CORREO</td>";
      ?>
      <td>
              <form action="../scripts/verperfil.php" method="post">
         <input type="hidden" name="id" value="<?php echo $registro->ID; ?>">
          <input type="hidden" name="nombre" value="<?php echo $registro->NOMBRE; ?>">
          <input type="hidden" name="direccion" value="<?php echo $registro->DIRECCION; ?>">
          <input type="hidden" name="telefono" value="<?php echo $registro->TELEFONO; ?>">
          <input type="hidden" name="correo" value="<?php echo $registro->CORREO; ?>">
          <button type="submit" class="btn btn-sm btn-primary mb-1">Editar</button>
        </form>
      </td>
      <?php
      echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";

   ?>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>