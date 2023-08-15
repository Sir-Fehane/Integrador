<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Nuevo</title>
</head>
<body>
  <?php
          include "../class/database.php";
          $db = new Database();
          $db->conectarDB();
  ?>
<div class="container w-75 p-5">
    <div class="d-flex">
        <a class="btn btn-primary" href="../views/admin.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Añadir Productos</h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="ACTIVO" name="estado">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tamaño" class="form-label">Tamaño:</label>
            <select class="form-control" name="tamaño">
                <option value="INDIVIDUAL">Individual</option>
                <option value="MEDIANA">Mediana</option>
                <option value="GRANDE">Grande</option>
                <option value="EXTRA">Extra</option>
                <option value="EVENTOS">Eventos</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Descripcion:</label>
            <input type="text" name="desc" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prec" class="form-label">Precio:</label>
            <input type="number" name="prec" class="form-control" required onkeypress="return validarNumero(event)>
        </div>
        
        <div class="mb-3">
    <label for="archivo" class="form-label">Imagen del producto:</label>
    <input class="form-control" type="file" name="archivo" id="archivo">
</div>
            <button type="submit" name="submit" class="btn btn-primary">Agregar producto</button>
        </div>
    </form>
</div>
<?php
require '../vendor/autoload.php'; // Carga la biblioteca AWS SDK

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

if(isset($_POST['submit']))
{
    // Extraer los datos del formulario
    extract($_POST);

    // Configurar el cliente de Amazon S3
    $s3 = new S3Client([
        'region' => 'us-east-1', // Cambia a tu región
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAV5QGATLUOBCH7VWK',
            'secret' => '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',
        ],
    ]);

    // Subir la imagen al bucket S3
    $bucket = 'toys-pizza'; // Cambia al nombre de tu bucket
    $archivo_temporal = $_FILES['archivo']['tmp_name'];
    $nombre_archivo = $_FILES['archivo']['name'];
    $ruta_s3 = 'imagenes/' . $nombre_archivo; // Cambia la ruta según tu estructura

    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $ruta_s3,
            'SourceFile' => $archivo_temporal,
        ]);

        // La URL de la imagen en S3
        $url_imagen_s3 = $result['ObjectURL'];

        // Insertar los datos en la base de datos
        $cadena = "INSERT INTO PRODUCTOS (NOMBRE,TAMANO,DESCRIPCION,PRECIO,ESTADO,img_prod) VALUES ('$nombre','$tamaño','$desc','$prec','ACTIVO','$url_imagen_s3');";
        $db->ejecutarsql($cadena);
        header("location: Exito.php");
    } catch (AwsException $e) {
        echo "Error al subir la imagen: " . $e->getMessage();
    }
}
?>
<<<<<<< HEAD
<script>
      function validarNumero(event) {
    const charCode = (event.which) ? event.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
    </script>
=======
>>>>>>> a1fc7d817ff273894346e518e325ad3a2b7f05c2
</body>
</html>
