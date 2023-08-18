
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="../js/bootstrap.bundle.js"></script>
  <link rel="stylesheet" href="../css/boot.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
 
  <title>Inventario</title>
</head>
<body>
<?php
$correo = $_SESSION['correo'];
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB(); ?>
<div class="container">

<div align="center"><h3>Historial de tus pedidos</h3></div>
</div>
    <?php
    $valor = 3;
    extract($_POST);
    $cadena = "SELECT OV.NO_ORDEN AS 'Numero', S.NOMBRE AS 'Sucursal', U.NOMBRE AS 'Cliente', CONCAT(P.NOMBRE,' ', P.TAMANO) AS 'Producto',
    DEO.CANTIDAD AS 'Cantidad', OV.TOTAL AS 'Total', OV.HORA_FECHA AS 'Fecha', OV.ESTADO AS 'Estado'
    FROM ORDEN_VENTA OV
    JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
    JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
    JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
    JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
    WHERE OV.ESTADO IN ('CANCELADA', 'ENTREGADA') AND U.CORREO = '$correo' group by OV.NO_ORDEN ";
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
    <div class="table-responsive">
        <table class='table table-hover' id='historial'>
            <thead class='table-danger' align='center'>
                <tr>
                <th class='col-2 col-lg-1 sortable'>Orden</th>
                 
                    <th class='col-2 col-lg-2 sortable'>Total</th>
                    <th class='col-2 col-lg-3 sortable'>Fecha</th>
                    <th class='col-2 col-lg-2 sortable'>Estado</th>
                    <th class="col-1 col-lg-2">Detalles</th>
                </tr>
            </thead>
            <tbody align='center'>
                <?php
                foreach ($tabla as $registro) {
                    echo "<tr>";
                    echo "<td>$registro->Numero</td>";
                  
                    echo "<td>$registro->Total</td>";
                    echo "<td>$registro->Fecha</td>";
                    echo "<td>$registro->Estado</td>";
                    ?>
                    <td>
                      <form method="post" action="../scripts/DetalleOrdenesp.php">
                        <input type="hidden" name="num" value="<?php echo $registro->Numero; ?>">
                        <button type="submit" class="btn btn-sm btn-primary">Ver detalle</button>
                      </form>
                    </td>
                    <?php
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


 


<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#historial').DataTable({
        "order": [[<?php echo $valor; ?>, 'desc']]
    });
});
  </script>
</body>
</html>