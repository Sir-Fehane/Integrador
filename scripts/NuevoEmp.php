<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Nuevo</title>
</head>
<body>
<div class="container w-75 p-5">
    <div class="d-flex">
        <a class="btn btn-primary" href="../views/admin.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Añadir Insumo</h3>
    </div>
    <form action="" method="post">
        <input type="hidden" value="ACTIVO" name="estado">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del empleado:</label>
            <input type="text" name="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label for="direc" class="form-label">Direccion:</label>
            <input type="text" name="direc" class="form-control">
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">Telefono:</label>
            <input type="text" name="tel" class="form-control">
        </div>
        <div class="mb-3">
            <label for="contra" class="form-label">Contraseña:</label>
            <input type="text" name="contra" class="form-control">
        </div>
        <div class="mb-3">
        <label for="puesto" class="form-label">Puesto:</label>
        <select name="puesto" class="form-select">
            <option value="EMP GENERAL">EMPLEADO GENERAL</option>
            <option value="ENCARGADO">ENCARGADO</option>
            <option value="ADMINISTRADOR">ADMINISTRADOR</option>
        </select>
        </div>
        <div class="mb-3">
            <label for="sucur" class="form-label">Sucursal:</label>
            <?php
            include "../class/database.php";
            $db = new Database();
            $db->conectarDB();
        $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
        $reg = $db->seleccionar($cadena);
        echo "<div class='me-2'>
            <select name='sucur' class='form-select'>";
        foreach ($reg as $value) 
        {
            echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
        }
        echo "</select>
        </div>";
        ?>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Añadir Empleado</button>
        </div>
    </form>
</div>
<?php
if(isset($_POST['submit']))
{
    extract($_POST);
    $hash = password_hash($contra, PASSWORD_DEFAULT);
    if($puesto == "ADMINISTRADOR")
    {
        $cadena = "INSERT INTO USUARIOS (NOMBRE,DIRECCION,TELEFONO,CONTRASENA,ROL) VALUES ('$nombre','$direc','$tel','$hash',1);";
        $db->ejecutarsql($cadena);
    }
    else
    {
        $cadena = "INSERT INTO USUARIOS (NOMBRE,DIRECCION,TELEFONO,CONTRASENA,ROL) VALUES ('$nombre','$direc','$tel','$hash',3);";
        $db->ejecutarsql($cadena);
        $cadena = "INSERT INTO EMPLEADO_SUCURSAL (EMPLEADO,PUESTO,SUCURSAL,ESTADO) VALUES ((SELECT ID_USUARIO FROM USUARIOS WHERE NOMBRE = '$nombre' AND ROL = 3
        ORDER BY ID_USUARIO DESC LIMIT 1),'$puesto',$sucur,'ACTIVO');";
        $db->ejecutarsql($cadena);
    }
    
    $db->desconectarDB();
    header("Location: Exito.php");
    exit;
}
?>
</body>
</html>
