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
        <a class="btn btn-primary" href="../views/verperfilv.php">Regresar</a>
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
        <label for="nuevotel" class="form-label">Telefono:</label>
        <input type="text" name="nuevotel" class="form-control" value="<?php echo $telefono;?>">
        </div>
        <div class="mb-3">
        <label for="nuevopres" class="form-label">Correo:</label>
        <input type="text" name="nuevocor" class="form-control" value="<?php echo $correo;?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
            if(isset($_POST['submit']))
            {
                $cadena = "UPDATE USUARIOS SET NOMBRE = '$nuevonom', DIRECCION = '$nuevodir', TELEFONO = '$nuevotel' , CORREO = '$nuevocor' WHERE ID_USUARIO = $id";
                $db->ejecutarsql($cadena);
                $db->desconectarDB();
                header("Location: exitoperf.php");
                exit;
            }
        ?>
</div>
</body>
</html>
