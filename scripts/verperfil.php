<?php
session_start();
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
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
<body style="background-color: #D6CFCF;">
    <?php
    include '../class/database.php';
    $db = new database();
    $db->conectarDB();
    ?>
<div class="container w-75 mt-5 shadow p-3 mb-5 rounded" style="width: 60%;  height: 30%; background-color:white">
    <div class="d-flex">
        <a class="btn btn-primary" href="../views/verperfilv1.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Editar Perfil</h3>
    </div>
    <form action="" method="POST">
        <?php
        extract($_POST);
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Nombre</label>
            <input type="text" name="nuevonom" class="form-control" value="<?php echo $nombre;?>">
        </div>
        <div class="mb-3">
        <label for="nuevocat" class="form-label">Direccion</label>
        <input type="text" name="nuevodir" class="form-control" value="<?php echo $direccion;?>">
        </div>
        <div class="mb-3">
        <label for="nuevotel" class="form-label" >Telefono (10 caracteres):</label>
        <input type="text" name="telefono" class="form-control" oninput="filterNonNumeric(event)" required pattern="[0-9]{10}" required inputmode="numeric"value="<?php echo $telefono;?>">
        </div>


        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
            if(isset($_POST['submit']))
            {
                $cadena = "UPDATE USUARIOS SET NOMBRE = '$nuevonom', DIRECCION = '$nuevodir', TELEFONO = '$nuevotel' WHERE ID_USUARIO = $id";
                $db->ejecutarsql($cadena);
                $db->desconectarDB();
                header("Location: ../views/verperfilv1.php");
                exit;
            }
        ?>
</div>
<script src="../src/validaciones.js">
</script>
</body>
</html>
