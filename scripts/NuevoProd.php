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
        <a class="btn btn-primary" href="../views/Productos.php">Regresar</a>
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
            <label for="ingredientes" class="form-label">Ingredientes:</label>
            <select class="form-control" id="ingredientes" name ="ingr">
                <?php
                $db = new Database();
                $db->conectarDB();
                $cadena = "SELECT ID_INS,NOMBRE FROM INVENTARIO WHERE ESTADO = 'ACTIVO' AND CATEGORIA = 1;";
                $reg = $db->seleccionar($cadena);
                foreach ($reg as $opt)
                {
                    echo "<option value='".$opt->ID_INS."'>".$opt->NOMBRE."</option>";
                }
                ?>
            </select>
            <button type="button" class="btn btn-primary" onclick="agregarIngrediente()">Agregar Ingrediente</button>
            <div class="row" id="ingredientes-agregados">
            </div>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Descripción:</label>
            <input type="text" name="desc" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prec" class="form-label">Precio:</label>
            <input type="number" name="prec" min="0" class="form-control" required onkeypress="return validarNumero(event)">
        </div>
        <div class="mb-3">
            <label for="archivo" class="form-label">Imagen del producto:</label>
            <input class="form-control" type="file" name="archivo" id="archivo">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary" id="bloqueo" onclick="cambiarContenido()" disabled>Agregar producto</button>
        </div>
    </form>
</div>
<script>
    const archivoInput = document.getElementById('archivo');
    const botonAgregarProducto = document.getElementById('bloqueo');

    archivoInput.addEventListener('change', function() {
        botonAgregarProducto.disabled = archivoInput.files.length === 0;
    });
</script>



<?php
require '../vendor/autoload.php'; // Carga la biblioteca AWS SDK

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

if(isset($_POST['submit']))
{
    // Extraer los datos del formulario
    extract($_POST);
    $ingredientes_seleccionados = $_POST['ingredientes_valores'];
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
        foreach ($ingredientes_seleccionados as $ingrediente)
        {
            $cadena = "INSERT INTO PROD_INV (PRODUCTO,INGREDIENTE) VALUES ((SELECT CODIGO FROM PRODUCTOS WHERE NOMBRE = '$nombre'),$ingrediente);";
            $db->seleccionar($cadena);
        }
        header("location: Exito.php");
    } catch (AwsException $e) {
        echo "Error al subir la imagen: " . $e->getMessage();
    }
}
?>
<script>
      function validarNumero(event) {
    const charCode = (event.which) ? event.which : event.keyCode;
    if (charCode == 46 || (charCode >= 48 && charCode <= 57)) {
        return true;
    }
    return false;
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var boton = document.getElementById("bloqueo");
    var form = document.querySelector("form");

    form.addEventListener("submit", function() {
        boton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...';
        boton.style.cursor = "not-allowed";
    });
});
</script>
<script>
// Declarar una variable para rastrear los ingredientes seleccionados
var ingredientesSeleccionados = new Set();

function agregarIngrediente() {
    var select = document.getElementById("ingredientes");
    var selectedValue = select.value;
    var selectedText = select.options[select.selectedIndex].text;
    
    if (ingredientesSeleccionados.has(selectedValue)) {
        alert("¡Este ingrediente ya ha sido agregado!");
        return;
    }
    
    ingredientesSeleccionados.add(selectedValue);
    
    var ingredientesDiv = document.getElementById("ingredientes-agregados");
    var inputWrapper = document.createElement("div");
    inputWrapper.classList.add("col-6", "col-lg-2", "mt-1");
    
    var input = document.createElement("input");
    input.type = "text";
    input.value = selectedText;
    input.name = "ingredientes[]";
    input.classList.add("form-control");
    input.readOnly = true;
    
    var hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.value = selectedValue;
    hiddenInput.name = "ingredientes_valores[]";
    
    inputWrapper.appendChild(input);
    inputWrapper.appendChild(hiddenInput);
    ingredientesDiv.appendChild(inputWrapper);
}

</script>
</body>
</html>
