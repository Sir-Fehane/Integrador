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
    <title>Detalle</title>
</head>
<body>
<?php
        include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
        extract($_POST);
        ?>
<div class="container p-5">
    <div class="d-flex">
        <a class="btn btn-primary" href="../views/Ordenes.php">Regresar</a>
        <h3 align="center" style="margin-left: 20%;">Detalle de la orden #<?php echo $num; ?></h3>
    </div>
    <?php
    $consulta = "SELECT OV.NO_ORDEN AS '#', S.NOMBRE AS 'Sucursal', U.NOMBRE AS 'Cliente', 
CONCAT(P.NOMBRE,' ',P.TAMANO) AS 'Producto', OV.FORMA_PAGO,
OV.TOTAL AS 'Total', OV.HORA_FECHA AS 'Fecha', OV.ESTADO AS 'Estado'
FROM ORDEN_VENTA OV
JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
WHERE OV.NO_ORDEN = $num
LIMIT 1;";
$registro = $db->seleccionar($consulta);
?>
    <div class="container card">
    <?php foreach ($registro as $row) 
    { ?>
        <div class="detalle-orden">
          <div class="row mb-3">
            <div class="col-12 col-lg-4">
              <label for="sucursal" class="form-label" >Sucursal:</label>
              <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Sucursal; ?>">
            </div>
            <div class="col-6 col-lg-4">
              <label for="cliente" class="form-label" >Cliente:</label>
              <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Cliente; ?>">
            </div>
            <div class="col-6 col-lg-4">
              <label for="fecha" class="form-label" >Fecha:</label>
              <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Fecha; ?>">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-lg-6">
              <label for="productos" class="form-label" >Producto(s):</label>
              <?php $consulta = "SELECT P.NOMBRE, P.TAMANO 
              FROM ORDEN_VENTA OV
              JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
              JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
              JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
              JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
              WHERE OV.NO_ORDEN = $num;";
              $reg = $db->seleccionar($consulta);
              foreach ($reg as $rw)
              { ?>
                <p><?php echo $rw->NOMBRE." ". $rw->TAMANO ;?></p>
              <?php 
              } ?>
            </div>
            <div class="col-12 col-lg-6">
            <label for="FP" class="form-label" >Forma de pago:</label>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->FORMA_PAGO; ?>">
            <label for="FP" class="form-label" >Total:</label>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo "$".$row->Total; ?>">
            <label for="Estado" class="form-label" >Estado:</label>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Estado; ?>">
            </div>
          </div>
        </div>
    <?php } ?>
    </div>
</div>
</body>
</html>