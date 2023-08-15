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
        <a class="btn btn-primary" href="../views/admin.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Editar Producto</h3>
    </div>
    <form action="" method="POST">
        <?php
        extract($_POST);
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Nombre</label>
            <input type="text" name="nuevonom" class="form-control" value="<?php echo $nombre;?>" required>
        </div>
        <div class="mb-3">
        <label for="nuevocat" class="form-label">Direccion</label>
        <input type="text" name="nuevodir" class="form-control" value="<?php echo $tamaño;?>" required>
        </div>
        <div class="mb-3">
        <label for="nuevotel" class="form-label">Telefono:</label>
        <input type="text" name="nuevotel" class="form-control" value="<?php echo $tamaño;?>" required>
        </div>
        <div class="mb-3">
        <label for="nuevopres" class="form-label">Correo:</label>
        <input type="text" name="nuevocor" class="form-control" value="<?php echo $desc;?>" required>
        </div>
        <div class="mb-3">
        <label for="nuevopres" class="form-label">precio:</label>
        <input type="text" name="nuevocor1" class="form-control" value="<?php echo $precio;?>" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
            if(isset($_POST['submit']))
            {
                $cadena = "UPDATE PRODUCTOS SET NOMBRE = '$nuevonom', TAMANO = '$nuevodir', TAMANO = '$nuevotel' , DESCRIPCION = '$nuevocor', PRECIO = '$nuevocor1' WHERE CODIGO = $id";
                $db->ejecutarsql($cadena);
                $db->desconectarDB();
                header("Location: ../views/admin.php");
                exit;
            }
        ?>
</div>
</body>
</html>
