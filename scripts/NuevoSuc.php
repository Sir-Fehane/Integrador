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
    <title>Nuevo</title>
</head>
<body>
<div class="container w-75 p-5">
    <div class="d-flex">
        <a class="btn btn-primary justify-content-center" href="../views/Sucursales.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Nueva Sucursal</h3>
    </div>
    <form action="" method="post">
        <input type="hidden" value="ACTIVO" name="estado">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la sucursal:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="dire" class="form-label">Dirección:</label>
            <div class="input-group">
                <input type="text" name="calle" class="form-control" required placeholder="Calle y numero">
                <input type="text" name="col" class="form-control" required placeholder="Colonia">
            </div>
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">Teléfono:</label>
            <input type="text" name="tel" class="form-control" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Añadir sucursal</button>
        </div>
    </form>
</div>
<?php
if(isset($_POST['submit']))
{
    include "../class/database.php";
    $db = new Database();
    $db->conectarDB();
    try
    {
    extract($_POST);
            $cadena = "INSERT INTO SUCURSALES (NOMBRE, DIRECCION, TELEFONO, ESTADO) VALUES ('$nombre', CONCAT('$calle',' ','$col'), '$tel','ACTIVO')";
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
</body>
</html>
