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
<div class="container w-75 p-5">
    <div class="d-flex">
        <a class="btn btn-primary justify-content-center" href="../views/Sucursales.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Editar Sucursal</h3>
    </div>
    <form action="" method="POST">
        <?php
        extract($_POST);
        ?>
        <input type="hidden" name="nuvsuc" value="<?php echo $suc; ?>">
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Nombre de la Sucursal:</label>
            <input type="text" name="nuevonom" class="form-control" value="<?php echo $nom;?>" required>
        </div>
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Dirección:</label>
            <input type="text" name="nuevodir" class="form-control" value="<?php echo $dir;?>" required>
        </div>
        <div class="mb-3">
        <label for="nuevotel" class="form-label">Teléfono:</label>
            <input type="text" name="nuevotel" class="form-control" value="<?php echo $tel;?>" required>
        </div> 
        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
            if(isset($_POST['submit']))
            {
                try{
                    include "../class/database.php";
                $db = new Database();
                $db->conectarDB();
                $cadena = "UPDATE SUCURSALES SET NOMBRE = '$nuevonom', DIRECCION = '$nuevodir', TELEFONO = '$nuevotel'
                WHERE ID_SUC = $nuvsuc";
                $db->ejecutarsql($cadena);
                $db->desconectarDB();
                header("Location: Exito.php");
                exit;
                }
                catch(PDOException $e) 
                {
                    header("Location: Fallo.php");
                }
            }
        ?>
</div>
</body>
</html>
