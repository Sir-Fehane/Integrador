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
    $consulta1 = "SELECT U.ID_USUARIO AS ID, U.NOMBRE AS 'NOMBRE', U.DIRECCION AS 'DIRECCION', U.TELEFONO AS 'TELEFONO', U.CORREO AS 'CORREO',
    U.img_chidas FROM USUARIOS U
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
   
 <!-- cambio de foto de perfil -->
<form action="../views/verperfilv.php" method="post" enctype="multipart/form-data">
    <input type="file" name="archivo" id="archivo">
    <input type="submit" value="Subir archivo">
</form>

   <?php
require '../Integrador/vendor'; // Carga el autoload del AWS SDK para PHP

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
// Verificar si se envió el formulario con un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo"])) {
  $archivoTemporal = $_FILES["archivo"]["tmp_name"];
  $nombreArchivo = $_FILES["archivo"]["name"];
// Configura el cliente de Amazon S3

$credentials = [
    'key'    => 'AKIAV5QGATLUOBCH7VWK',
    'secret' => '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',
];

$s3Client = new S3Client([
    'version'     => 'latest',
    'region'      => 'us-east-1', // Cambia a tu región preferida
    'credentials' => $credentials,
]);
// Ruta de destino en S3 donde quieres guardar la imagen
$destinoEnS3 = 'imagenes/'.$nombreArchivo;

// Intenta subir la imagen a S3
try {
    $result = $s3Client->putObject([
        'Bucket' => 'toys-pizza',
        'Key'    => $destinoEnS3,
        'SourceFile' => $archivoTemporal,
    ]);

    // Si todo salió bien, la imagen se subió correctamente a S3
    extract($_POST);
    $cadena = "UPDATE USUARIOS SET img_chidas='https://toys-pizza.s3.amazonaws.com/imagenes/$nombreArchivo' WHERE ID_USUARIO = $registro->ID;";
    $db->ejecutarsql($cadena);
    echo 'La imagen se subió correctamente a Amazon S3.';

} catch (S3Exception $e) {
    // En caso de error, captura la excepción y muestra un mensaje
    echo "Error al subir la imagen a Amazon S3: {$e->getMessage()}";
}
}
?>
<?php
$imgchida = $registro->img_chidas;
echo "<img src='$imgchida' alt='sexogratis'>";
?>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>