
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../css/boot.css">
  <title>Inventario</title>
</head>
<body>
<?php
$correo = $_SESSION['correo'];
  $fechaActual = date("d/m/Y");
  $db = new Database();
  $db->conectarDB(); ?>
<div class="container"><br>
<div align="center"><h3>Órdenes pendientes de aceptar en sucursal. </h3></div>
<div align="center"><h3>Una vez aceptada la orden, no se podrá cancelar.</h3></div>
</div>
    <?php
    $valor = 3;
    extract($_POST);
    $cadena = "SELECT OV.NO_ORDEN , S.NOMBRE AS 'Sucursal', U.NOMBRE AS 'Cliente', CONCAT(P.NOMBRE,' ', P.TAMANO) AS 'Producto',
    DEO.CANTIDAD AS 'Cantidad', OV.TOTAL AS 'Total', OV.HORA_FECHA AS 'Fecha', OV.ESTADO AS 'Estado'
    FROM ORDEN_VENTA OV
    JOIN DETALLE_ORDEN DEO ON DEO.NO_ORDEN = OV.NO_ORDEN
    JOIN SUCURSALES S ON OV.SUCURSAL = S.ID_SUC
    JOIN USUARIOS U ON OV.USUARIO = U.ID_USUARIO
    JOIN PRODUCTOS P ON DEO.PRODUCTO = P.CODIGO
    WHERE OV.ESTADO = 'PENDIENTE' AND U.CORREO = '$correo' group by OV.NO_ORDEN ";
    $tabla = $db->seleccionar($cadena);
    ?>
    <div class="container justify-content-center">
    <div class="table-responsive">
        <table class='table table-hover' id='DetalleOrd'>
            <thead class='table-danger' align='center'>
                <tr>
                <th class='col-2 col-lg-1 sortable'>Orden</th>
                    <th class='col-2 col-lg-2 sortable'>Total</th>
                    <th class='col-2 col-lg-3 sortable'>Fecha</th>
                    <th class='col-2 col-lg-2 sortable'>Estado</th>
                    <th class="col-1 col-lg-2 sortable">Detalles</th>
                    <th class="col-1 col-lg-2 sortable">Cancelar</th>
                </tr>
            </thead>
            <!-- Tu encabezado y contenido anterior -->

<tbody align='center'>
    <?php foreach ($tabla as $registro) { ?>
        <tr>
            <td><?php echo $registro->NO_ORDEN; ?></td>
            <td><?php echo $registro->Total; ?></td>
            <td><?php echo $registro->Fecha; ?></td>
            <td><?php echo $registro->Estado; ?></td>
            <td>
                <form method="post" action="../scripts/DetalleOrdenesp.php">
                    <input type="hidden" name="num" value="<?php echo $registro->NO_ORDEN; ?>">
                    <button type="submit" class="btn btn-sm btn-primary">Ver detalle</button>
                </form>
            </td>
            <td>
                        <button type="button" class="btn btn-danger cancel-button" data-order="<?php echo $registro->NO_ORDEN; ?>">Cancelar orden</button>
                    </td>
                </tr>
<!-- Modal para confirmación -->
<div class="modal fade" id="confirmModal<?php echo $registro->NO_ORDEN; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Cancelación</h5>
                <button type="button" class="close d-none" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de cancelar la orden?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-confirm-no" data-order="<?php echo $registro->NO_ORDEN; ?>">No</button>
                <form action="../scripts/cancelar.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $registro->NO_ORDEN; ?>">
                    <button type="submit" class="btn btn-danger btn-confirm-yes" name="eliminar">Sí</button>
                </form>
            </div>
        </div>
    </div>
</div>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#DetalleOrd').DataTable({
            "order": [[<?php echo $valor; ?>, 'desc']]
        });

        // Agregamos un listener para los botones de cancelar
        $('.cancel-button').on('click', function() {
            var orderNumber = $(this).data('order');
            $('#confirmModal' + orderNumber).modal('show');
        });

        // Agregamos un listener para el botón "Sí" dentro del modal
        $('.modal').on('click', '.btn-confirm-yes', function() {
            var orderNumber = $(this).data('order');
            $('#confirmModal' + orderNumber).modal('hide');
        });

        // Agregamos un listener para el botón "No" dentro del modal
        $('.modal').on('click', '.btn-confirm-no', function() {
            var orderNumber = $(this).data('order');
            $('#confirmModal' + orderNumber).modal('hide');
        });
    });
</script>
</body>
</html>