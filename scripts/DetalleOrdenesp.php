<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../css/boot.css">
    <title>Detalle</title>
</head>
<body>
<?php
    session_start();
    include "../class/database.php";
    $db = new Database();
    $db->conectarDB();
    extract($_POST);
?>
<nav class="navbar navbar-expand-lg he">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#">
                <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
                Toy's Pizza
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active navtext text-dark" aria-current="page" href="../views/mispedidos.php">regresar</a>
              </li>
                </ul>
            </ul>
              <li class="nav-item navtext">
                <div class="container">
                  <div class="d-flex justify-content">
                  </div>
              </div>
              </li>
          </div>
        </div>
      </nav>
<div class="container p-5">
    <div class="d-flex align-items-center">   
        <h3 class="text-center mb-0">Detalle de la orden #<?php echo $num; ?></h3>
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
    <div class="card mt-4">
        <?php foreach ($registro as $row) { ?>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="sucursal" class="form-label"><strong>Sucursal:</strong></label>
                        <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Sucursal; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="cliente" class="form-label"><strong>Cliente:</strong></label>
                        <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Cliente; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha" class="form-label"><strong>Fecha:</strong></label>
                        <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Fecha; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="productos" class="form-label"><strong>Producto(s):</strong></label>
                        <?php 
                        $consulta = "SELECT P.NOMBRE, P.TAMANO 
                        FROM ORDEN_VENTA OV
                        JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
                        JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
                        JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
                        JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
                        WHERE OV.NO_ORDEN = $num;";
                        $reg = $db->seleccionar($consulta);
                        foreach ($reg as $rw) { ?>
                            <p><?php echo $rw->NOMBRE." ". $rw->TAMANO ;?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <label for="productos" class="form-label"><strong>Cantidad:</strong></label>
                        <?php 
                        $consulta1 = "SELECT DEO.CANTIDAD, DEO.CANTIDAD * P.PRECIO AS SUBTOTAL
                        FROM ORDEN_VENTA OV
                        JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
                        JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
                        JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
                        JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
                        WHERE OV.NO_ORDEN = $num;";
                        $reg1 = $db->seleccionar($consulta1);
                        foreach ($reg1 as $rw1) { ?>
                            <p><?php echo $rw1->CANTIDAD;?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <label for="productos" class="form-label"><strong>Subtotal:</strong></label>
                        <?php 
                        $consulta1 = "SELECT DEO.CANTIDAD, DEO.CANTIDAD * P.PRECIO AS SUBTOTAL
                        FROM ORDEN_VENTA OV
                        JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
                        JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
                        JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
                        JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
                        WHERE OV.NO_ORDEN = $num;";
                        $reg2 = $db->seleccionar($consulta1);
                        foreach ($reg2 as $rw2) { ?>
                            <p><?php echo $rw2->SUBTOTAL;?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-3 align-end">
                        <label for="FP" class="form-label"><strong>Forma de pago:</strong></label>
                        <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->FORMA_PAGO; ?>">
                        <label for="FP" class="form-label"><strong>Total:</strong></label>
                        <input type="text" readonly class="form-control-plaintext" value="<?php echo "$".$row->Total; ?>">
                        <label for="Estado" class="form-label"><strong>Estado:</strong></label>
                        <input type="text" readonly class="form-control-plaintext" value="<?php echo $row->Estado; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="productos" class="form-label"><strong>Notas:</strong></label>
                        <?php 
                        $consulta1 = "SELECT DEO.NOTAS, DEO.CANTIDAD * P.PRECIO AS SUBTOTAL
                        FROM ORDEN_VENTA OV
                        JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
                        JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
                        JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
                        JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
                        WHERE OV.NO_ORDEN = $num;";
                        $reg2 = $db->seleccionar($consulta1);
                        foreach ($reg2 as $rw2) { ?>
                            <p><?php echo $rw2->NOTAS;?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>