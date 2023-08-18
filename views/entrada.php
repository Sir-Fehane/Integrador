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
  } elseif ($_SESSION["rol"] == 1) { 
    header("Location: admin.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="../src/app.js"></script>
</head>
<body>
    <!--Header/navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="puntoventa.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cocina.PHP">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="pendientes.php">Pendientes</a>
            </li>
            <li>
              <h6 id="miTabla"></h6>
            </li>
            <li>
              <a class="nav-link" href="cierre.php">Cierre</a>
            </li>
            <li>
              <a class="nav-link" href="solicitar.php">Solicitar</a>
            </li>
            <li>
              <a class="nav-link" href="solicitudnueva.php">Entrada</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="verperfilv1.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Perfil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../scripts/cerrarSesion.php">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Contenido -->
    <div class="container mt-5">
    <h2 class="text-center">Entrada de insumos</h2>
    <hr>
    <?php
    include '../class/database.php';
    $conexion = new database();
    $conexion->conectarDB();
    $id_usuario = $_SESSION["IDUSU"];
    $consulta_sucursal = "SELECT SUCURSAL FROM EMPLEADO_SUCURSAL WHERE EMPLEADO = '$id_usuario'";
    $resultado_sucursal = $conexion->seleccionar($consulta_sucursal);
    $sucursal_id = $resultado_sucursal[0]->SUCURSAL;

    $consulta = "SELECT DISTINCT SOLICITUDES.ID_SOLICITUD as S, SOLICITUDES.FECHA as F FROM SOLICITUDES 
    INNER JOIN DETALLE_SOLICITUD ON SOLICITUDES.ID_SOLICITUD = DETALLE_SOLICITUD.SOLICITUD
    WHERE SOLICITUDES.ESTADO = 'solicitado' AND SOLICITUDES.SUCURSAL = $sucursal_id";
    $reg = $conexion->seleccionar($consulta);
    
    if (empty($reg)) {
        echo '<h4 class="text-center">Por el momento no hay solicitudes pendientes...</h4>';
    } else {
        foreach ($reg as $value) : ?>
            <div class="table-responsive">
                <form action="../scripts/gentrada.php" method="post">
                    <table class="table table-bordered mt-4">
                        <thead class="table-dark">
                            <tr>
                                <th colspan="12" class="text-center">Solicitud: <?php echo $value->S; ?></th>
                            </tr>
                            <tr>
                                <th colspan="12" class="text-center">Fecha de solicitud: <?php echo $value->F; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $solicitud_id = $value->S;
                            $consulta_detalles = "SELECT INVENTARIO.NOMBRE as N, INVENTARIO.PRESENTACION as P 
                            FROM SOLICITUDES 
                            INNER JOIN DETALLE_SOLICITUD ON SOLICITUDES.ID_SOLICITUD = DETALLE_SOLICITUD.SOLICITUD
                            INNER JOIN INVENTARIO ON INVENTARIO.ID_INS = DETALLE_SOLICITUD.INVENTARIO 
                            WHERE SOLICITUDES.ID_SOLICITUD = $solicitud_id";
                            $detalles = $conexion->seleccionar($consulta_detalles);

                            foreach ($detalles as $detalle) : ?>
                                <tr>
                                    <td colspan="6"><?php echo $detalle->N; ?> (<?php echo $detalle->P; ?>)</td>
                                    <td colspan="6">
                                        <input type="number" name="cantidades[<?php echo $value->S; ?>][<?php echo $detalle->N; ?>]" 
                                            class="form-control" 
                                            data-nombre="<?php echo $detalle->N; ?>"
                                            onkeypress="return validarNumero(event)" 
                                            placeholder="Ingresa la cantidad que llegó del insumo:" 
                                            required min="0" step="0.1">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12" class="text-center">
                                    <button class="btn btn-success" type="submit" name="guardarSolicitud" value='<?php echo $value->S; ?>'>Guardar Solicitud <?php echo $value->S; ?></button>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#AgregarInsumo-<?php echo $value->S; ?>">Añadir Insumo</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>

            <!-- Modal Agregar Insumo -->
            <div class="modal fade" id="AgregarInsumo-<?php echo $value->S; ?>" tabindex="-1" aria-labelledby="modalAgregarInsumoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAgregarInsumoLabel">Añadir Insumo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../scripts/detallesoli.php" method="post" id="agregarInsumoForm">
                                <input type="hidden" name="idSolicitud" value="<?php echo $solicitud_id; ?>">
                                <label for="insumo">Selecciona un insumo:</label>
                                <select name="insumo" class="form-control" id="modalInsumoSelect">
                                    <?php
                                    $consulta_insumos = "SELECT ID_INS, NOMBRE, PRESENTACION FROM INVENTARIO WHERE ESTADO = 'ACTIVO' 
                                    AND ID_INS NOT IN (SELECT INVENTARIO FROM DETALLE_SOLICITUD WHERE SOLICITUD = $solicitud_id)";
                                    $insumos_activos = $conexion->seleccionar($consulta_insumos);
                                    foreach ($insumos_activos as $insumo) {
                                        echo "<option value='{$insumo->ID_INS}'>{$insumo->NOMBRE} ({$insumo->PRESENTACION})</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                                <button type="submit" class="btn btn-primary" id="modalAddButton">Agregar Insumo</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php } ?>
</div>
<script>
    function validarNumero(event) 
    {
    const charCode = (event.which) ? event.which : event.keyCode;

    if (charCode == 46 || (charCode >= 48 && charCode <= 57)) {
        return true;
    }

    return false;
  }
    document.addEventListener('DOMContentLoaded', function () {
        const addButton = document.getElementById('modalAddButton');
        const insumoSelect = document.getElementById('modalInsumoSelect');
        const agregarInsumoForm = document.getElementById('agregarInsumoForm');
        const solicitudListContainer = document.getElementById('solicitudListContainer');

        addButton.addEventListener('click', function () {
            const selectedInsumoId = insumoSelect.value;
            if (selectedInsumoId !== '') {
                agregarInsumoForm.submit();
            }
        });
    });
</script>

</body>
</html>