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
        <a class="btn btn-primary" href="../views/admin.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Editar Empleado</h3>
    </div>
    <form action="" method="POST">
        <?php
        include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
        extract($_POST);
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Nombre:</label>
            <input type="text" name="nuevonom" class="form-control" value="<?php echo $nombre;?>">
        </div>
        <div class="mb-3">
            <label for="nuevodirec" class="form-label">direccion:</label>
            <input type="text" name="nuevodirec" class="form-control" value="<?php echo $direccion;?>">
        </div>
        <div class="mb-3">
            <label for="nuevotel" class="form-label">Telefono:</label>
            <input type="text" name="nuevotel" class="form-control" value="<?php echo $tel;?>">
        </div>
        <div class="mb-3">
        <label for="nuevopues" class="form-label">Puesto:</label>
        <select name="nuevopues" class="form-select">
        <option value="EMP GENERAL">EMPLEADO GENERAL</option>
            <option value="ENCARGADO">ENCARGADO</option>
        </select>
        </div>
        <div class="mb-3">
            <label for="nuevosucur" class="form-label">Sucursal:</label>
            <?php
        $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
        $reg = $db->seleccionar($cadena);
        echo "<div class='me-2'>
            <select name='nuevosucur' class='form-select'>";
        foreach ($reg as $value) 
        {
            echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
        }
        echo "</select>
        </div>";
        ?>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
        if(isset($_POST['submit']))
            {
                $cadena = "UPDATE USUARIOS SET NOMBRE = '$nuevonom', DIRECCION = '$nuevodirec', TELEFONO = '$nuevotel' WHERE ID_USUARIO = $id";
                $db->ejecutarsql($cadena);
                $cadena = "UPDATE EMPLEADO_SUCURSAL SET PUESTO = '$nuevopues', SUCURSAL = $nuevosucur
                WHERE EMPLEADO = $id";
                $db->ejecutarsql($cadena);
                $db->desconectarDB();
                header("Location: Exito.php");
                exit;
            }
        ?>
</div>
</body>
</html>
