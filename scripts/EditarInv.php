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
        <a class="btn btn-primary justify-content-center" href="../views/Inventario.php">Regresar</a>
        <h3 align="center" style="margin-left: 30%;">Editar Insumo</h3>
    </div>
    <form action="" method="POST">
        <?php
        extract($_POST);
        ?>
        <input type="hidden" name="idinv" value="<?php echo $idinv; ?>">
        <div class="mb-3">
            <label for="nuevonom" class="form-label">Nombre del insumo:</label>
            <input type="text" name="nuevonom" class="form-control" value="<?php echo $nombre;?>" required>
        </div>
        <div class="mb-3">
        <label for="nuevocat" class="form-label">Categoría:</label>
        <?php
        include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
        $cadena = "SELECT ID_CAT_INS,NOMBRE FROM CATEGORIAS_INS";
        $reg = $db->seleccionar($cadena);
        echo "
            <select name='nuevocat' class='form-select'>";
        foreach ($reg as $value) 
        {
            echo "<option value='".$value->ID_CAT_INS."'>".$value->NOMBRE."</option>";
        }
        echo "</select>";
        ?>
        </div>
        <div class="mb-3">
        <label for="nuevocant" class="form-label">Cantidad:</label>
        <input type="number" name="nuevocant" class="form-control" disabled value="<?php echo $existencia;?>">
        </div>
        <div class="mb-3">
        <label for="nuevopres" class="form-label">Presentación:</label>
        <select name="nuevopres" class="form-select">
            <option value="Kg">Kg</option>
            <option value="Lata">Lata</option>
            <option value="Recipiente">Recipiente</option>
            <option value="Litro">Litro</option>
            <option value="Bolsa">Bolsa</option>
            <option value="Vasos">Vasos</option>
            <option value="Paquete">Paquete</option>
            <option value="Caja">Caja</option>
            <option value="Molde">Molde</option>
        </select>
        </div>
        <div class="mb-3">
            <label for="nuevosucur" class="form-label">Sucursal:</label>
            <?php
        $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
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
            <button type="submit" name="editar" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    <?php
            if(isset($_POST['editar']))
            {
                try{
                    extract($_POST);
                    $cadena = "UPDATE INVENTARIO SET NOMBRE = '$nuevonom', CATEGORIA = $nuevocat, PRESENTACION = '$nuevopres' WHERE ID_INS = $idinv";
                    $db->ejecutarsql($cadena);
                    $cadena = "UPDATE INV_SUC SET SUCURSAL = $nuevosucur WHERE INVENTARIO = $idinv";
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
<script>
    var numero = document.getElementById('numero');
    function comprueba(valor){
    if(valor.value < 0){
    valor.value = 1;}
}
</script>
</body>
</html>
