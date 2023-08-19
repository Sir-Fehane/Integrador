<?php
session_start();
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Editar</title>
</head>
<body>
    <?php
    include '../class/database.php';
    $db = new database();
    $db->conectarDB();
    ?>
<div class="container w-75 p-5">
    <div class="d-flex">
        <a class="btn btn-primary" href="../views/Productos.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Editar Producto</h3>
    </div>
    <form action="" method="POST">
        <?php
        extract($_POST);
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Nombre:</label>
            <input type="text" name="nuevonom" class="form-control" value="<?php echo $nombre;?>" required>
        </div>
        <div class="mb-3">
        <label for="tamaño" class="form-label">Tamaño:</label>
            <select class="form-control" name="tamaño">
            <?php
                $db = new Database();
                $db->conectarDB();
                $cadena = "SELECT DISTINCT TAMANO FROM PRODUCTOS;";
                $reg = $db->seleccionar($cadena);
                foreach ($reg as $opt)
                {
                    echo "<option value='".$opt->TAMANO."'>".$opt->TAMANO."</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="ingredientes" class="form-label">Ingredientes:</label>
            <select class="form-control" id="ingredientes" name ="ingr">
                <?php
                $db = new Database();
                $db->conectarDB();
                $cadena = "SELECT ID_INS,NOMBRE FROM INVENTARIO WHERE ESTADO = 'ACTIVO' AND CATEGORIA = 1 AND ID_INS NOT IN (SELECT PI.INGREDIENTE FROM INVENTARIO I
                JOIN PROD_INV PI ON PI.INGREDIENTE = I.ID_INS
                JOIN PRODUCTOS P ON P.CODIGO = PI.PRODUCTO
                WHERE P.CODIGO = $id);";
                $reg = $db->seleccionar($cadena);
                foreach ($reg as $opt)
                {
                    echo "<option value='".$opt->ID_INS."'>".$opt->NOMBRE."</option>";
                }
                ?>
            </select>
            <button type="button" class="btn btn-primary" onclick="agregarIngrediente()">Agregar Ingrediente</button>
            <div class="row" id="ingredientes-agregados">
                <?php
                $consulta = "SELECT ID_INS,NOMBRE FROM INVENTARIO WHERE ESTADO = 'ACTIVO' AND CATEGORIA = 1 AND ID_INS IN (SELECT PI.INGREDIENTE FROM INVENTARIO I
                JOIN PROD_INV PI ON PI.INGREDIENTE = I.ID_INS
                JOIN PRODUCTOS P ON P.CODIGO = PI.PRODUCTO
                WHERE P.CODIGO = $id);";
                $reg = $db->seleccionar($consulta);
                foreach ($reg as $value) 
                {
                    ?>
                    <div class="col-6 col-lg-2 mt-1 d-flex">
                        <input type="text" class="form-control" name="ingredientes[]" value="<?php echo $value->NOMBRE ?>">
                        <input type="hidden" name="ingredientes_valores[]" value="<?php echo $value->ID_INS ?>">
                        <button type="button" class="btn btn-danger" onclick="eliminarDiv(this)"><i class="bx bx-minus-circle"></i></button>
                    </div>
                    <?php
                }
                ?>
                
            </div>
        </div>
        <div class="mb-3">
        <label for="nuevotel" class="form-label">Descripción:</label>
        <?php
        $consulta = "SELECT DESCRIPCION FROM PRODUCTOS WHERE CODIGO = $id";
        $reg = $db->seleccionar($consulta);
        foreach ($reg as $value) 
        {
        ?>
        <input type="text" name="nuevodesc" class="form-control" value="<?php echo $value->DESCRIPCION ?>" required><?php }?>
        </div>
        <div class="mb-3">
        <label for="nuevopres" class="form-label">precio:</label>
        <input type="text" name="nuevoprecio" class="form-control" value="<?php echo $precio;?>" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
        if(isset($_POST['submit']))
        {
            try
            {
            extract($_POST);
            $ingredientes_seleccionados = $_POST['ingredientes_valores'];
            // Insertar los datos en la base de datos
            $cadena = "UPDATE PRODUCTOS SET NOMBRE = '$nuevonom', TAMANO = '$tamaño', DESCRIPCION = '$nuevodesc', PRECIO = $nuevoprecio WHERE CODIGO = $id;";
            $db->ejecutarsql($cadena);
            $cadena = "DELETE FROM PROD_INV WHERE PRODUCTO = $id;";
                $db->seleccionar($cadena);
            foreach ($ingredientes_seleccionados as $ingrediente)
            {
                $cadena = "INSERT INTO PROD_INV (PRODUCTO,INGREDIENTE) VALUES ($id,$ingrediente);";
                $db->seleccionar($cadena);
            }
            header("location: Exito.php");
            } 
            catch (PDOException $e) 
            {
            header("location: Fallo.php");
            }
        }
    ?>
</div>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script>
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
    inputWrapper.classList.add("col-6", "col-lg-2", "mt-1","d-flex");

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

    var deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.innerHTML = "<i class='bx bx-minus-circle'></i>";
    deleteButton.classList.add("btn", "btn-danger");
    deleteButton.addEventListener("click", function() {
        ingredientesSeleccionados.delete(selectedValue);
        ingredientesDiv.removeChild(inputWrapper);
    });

    inputWrapper.appendChild(input);
    inputWrapper.appendChild(hiddenInput);
    inputWrapper.appendChild(deleteButton);

    ingredientesDiv.appendChild(inputWrapper);
}
</script>
<script>
function eliminarDiv(button) {
    var divToRemove = button.parentElement;
    divToRemove.parentNode.removeChild(divToRemove);
}
</script>
</body>
</html>
