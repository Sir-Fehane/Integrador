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
    <?php
    $error = false;
    ?>
<div class="container w-75 p-5">
    <div class="d-flex">
        <a class="btn btn-primary justify-content-center" href="../views/admin.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Añadir Insumo</h3>
    </div>
    <form action="" method="post">
        <input type="hidden" value="ACTIVO" name="estado">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del insumo:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
        <label for="categoria" class="form-label">Categoria:</label>
        <?php
        include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
        $cadena = "SELECT ID_CAT_INS,NOMBRE FROM CATEGORIAS_INS";
        $reg = $db->seleccionar($cadena);
        echo "
            <select name='categoria' class='form-select'>";
        foreach ($reg as $value) 
        {
            echo "<option value='".$value->ID_CAT_INS."'>".$value->NOMBRE."</option>";
        }
        echo "</select>";
        ?>
        </div>
        <div class="mb-3">
        <label for="pres" class="form-label">Presentacion:</label>
        <?php
        $db = new Database();
        $db->conectarDB();
        $cadena = "SELECT PRESENTACION FROM INVENTARIO GROUP BY PRESENTACION";
        $reg = $db->seleccionar($cadena);
        echo "
            <select name='pres' class='form-select'>";
        foreach ($reg as $value) 
        {
            echo "<option value='".$value->PRESENTACION."'>".$value->PRESENTACION."</option>";
        }
        echo "</select>";
        ?>
        </div>
        <div class="mb-3">
            <label for="sucur" class="form-label">Sucursal:</label>
            <?php
        $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
        $reg = $db->seleccionar($cadena);
        echo "<div class='me-2'>
            <select name='sucur' class='form-select'>";
        foreach ($reg as $value) 
        {
            echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
        }
        echo "<option value=''>TODAS LAS SUCURSALES</option>";
        echo "</select>
        </div>";
        ?>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-primary">Añadir insumo</button>
        </div>
    </form>
</div>
<?php
if(isset($_POST['submit']))
{
    try
    {
        extract($_POST);
        $cadena = "INSERT INTO INVENTARIO (NOMBRE, CATEGORIA, PRESENTACION, ESTADO) VALUES ('$nombre', '$categoria', '$pres', '$estado')";
        $db->ejecutarsql($cadena);
        if(empty($_POST['sucur']))
        {
            $suc = "SELECT ID_SUC FROM SUCURSALES";
            $reg = $db->seleccionar($suc);
            foreach ($reg as $value)
            {
                $cadena = "INSERT INTO INV_SUC (SUCURSAL, INVENTARIO, CANTIDAD, FECHA) VALUES ($value->ID_SUC, (SELECT ID_INS FROM INVENTARIO WHERE NOMBRE = '$nombre' ORDER BY ID_INS DESC LIMIT 1), 0, NOW())";
                $db->ejecutarsql($cadena);
            }
        }
        elseif(!empty($_POST['sucur']))
        {
            $cadena = "INSERT INTO INV_SUC (SUCURSAL, INVENTARIO, CANTIDAD, FECHA) VALUES ($sucur, (SELECT ID_INS FROM INVENTARIO WHERE NOMBRE = '$nombre' ORDER BY ID_INS DESC LIMIT 1), 0, NOW())";
            $db->ejecutarsql($cadena);
        }
        $db->desconectarDB();
        header("Location: Exito.php");
        exit;
    } catch(PDOException $e) 
    {
        header("Location: Fallo.php");
    }
}
?>
</body>
</html>
