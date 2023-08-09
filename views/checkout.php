<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cocina.PHP">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="cierre.php">Cierre</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="verperfilv.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <?php
    include '../class/database.php';
    $conexion = new database();
    $conexion->conectarDB();
    $cajero = $_SESSION['IDUSU'];

    $consulta_usuario = "SELECT NOMBRE FROM USUARIOS WHERE ID_USUARIO = '$cajero'";
    $resultado_usuario = $conexion->seleccionar($consulta_usuario);
    if (isset($_POST['btn_proceder_pago'])) {
        if ($resultado_usuario && count($resultado_usuario) > 0) {
            // Consultar la tabla EMPLEADO_SUCURSAL para obtener el sucursal_id del empleado
            $consulta_sucursal = "SELECT SUCURSALES.NOMBRE AS SN, SUCURSALES.ID_SUC AS IDSUC FROM SUCURSALES INNER JOIN EMPLEADO_SUCURSAL ON SUCURSAL = SUCURSALES.ID_SUC WHERE EMPLEADO = $cajero";
            $resultado_sucursal = $conexion->seleccionar($consulta_sucursal);
        
            if ($resultado_sucursal && count($resultado_sucursal) > 0) {
                $sucursal_id = $resultado_sucursal[0]->IDSUC;
            // Verificar si se envió el formulario de carrito y si se hizo clic en el botón "Proceder al pago"
            $productoID = isset($_POST['ID']) ? $_POST['ID'] : '';
            $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
            $nombreCliente = isset($_POST['nombre-cliente']) ? $_POST['nombre-cliente'] : '';
            $totalGeneral = isset($_POST['total_general']) ? $_POST['total_general'] : 0;
            $formaPago = isset($_POST['forma_pago']) ? $_POST['forma_pago'] : '';
            $tipoPedido = isset($_POST['tipo_pedido']) ? $_POST['tipo_pedido'] : '';
            // Verificar si el carrito está definido y no está vacío
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            }
            }     
            else {
                echo "No se encontró la sucursal del empleado.";
            }
        }
    }         
    ?>
    <div class="container" id="cuerpo11">
        <div class="row">
            <div class="col-sm-12"><h1 align="center">Detalles de la orden</h1></div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12 table-responsive">
                <!-- Interfaz para mostrar los detalles de la orden -->
 
                <?php if (isset($_SESSION['carrito'])) {?>
                <?php echo $nombreCliente;?>
                <table class="table align-middle table-sm">
                <thead class="table-light">
                    <tr>
                        <td colspan="3" class="text-center">
                        <form method="post">
                            <label for="forma_pago">Forma de pago:</label>
                            <select name="forma_pago" id="forma_pago"  class="form-select form-select-md mb-3 text-center" >
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="TARJETA">Tarjeta</option>
                            </select>           
                        </td>
                        <td colspan="2" class="text-center">
                            <label for="tipo_pedido">Tipo de pedido:</label>
                            <select name="tipo_pedido" id="tipo_pedido"  class="form-select form-select-md mb-3 text-center">
                                <option value="AQUI">Para comer aqui</option>
                                <option value="LLEVAR">Para llevar</option>
                            </select>
                        </td>    


                    </tr>
                    <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Tamaño</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio unitario</th>
                        <th class="text-center">Subtotal</th>
                    </tr>
                </thead>
                    <?php foreach ($_SESSION['carrito'] as $producto) { ?>
                        <tbody>
                        <tr>
                            
                            <td class="text-center"><?php echo $producto['titulo']; ?></td>
                            <td class="text-center"><?php echo $producto['tamaño']; ?></td>
                            <td class="text-center"><?php echo $producto['cantidad']; ?></td>
                            <td class="text-center"><?php echo $producto['precio']; ?></td>
                            <td class="text-center"><?php echo $producto['precio'] * $producto['cantidad']; ?></td>
                        </tr>
                    </tbody>

                    <?php } ?>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="table-light" ></td>
                            <td colspan="1">
                            <h3>Total: $<?php echo $totalGeneral; ?></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="table-light"></td>
                            <td colspan="2" class="text-center">
                            <div class="d-grid gap-1">
                                <button type="submit" class="btn btn-lg btn-success" name="pagar">Pagar</button>
                                </form>
                            </div>

                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>            
        </div>
    </div>
    <?php } else {
        echo "El carrito está vacío.";
    } ?>


    <?php echo $sucursal_id; ?>

    <!-- Formulario para seleccionar la forma de pago -->


    <?php
    if (isset($_POST['btn_proceder_pago'])) {
    // Insertar datos en la tabla ORDEN_VENTA
    $query_orden = "INSERT INTO ORDEN_VENTA (USUARIO, TIPO, TOTAL, FORMA_PAGO, SUCURSAL, HORA_FECHA)
    VALUES ('$nombreCliente', '$tipoPedido', '$totalGeneral', '$formaPago', '$sucursal_id', NOW())";

    $conexion->ejecutarSQL($query_orden);

    // Obtener el número de orden insertado
    $idorden = 0;
    $Orden = "SELECT MAX(NO_ORDEN) as IDO FROM ORDEN_VENTA WHERE SUCURSAL = '$sucursal_id' AND HORA_FECHA = NOW()";
    $noOrden = $conexion->selec($Orden);
    foreach($noOrden as $OV){
        $idorden = $OV['IDO']; 
        if($idorden == 0){
            $idorden = 1;
        } 
    }

    // Insertar datos en la tabla DETALLE_ORDEN
    foreach ($_SESSION['carrito'] as $prod) {
        $notas = '';
        $estado = 'EN PROCESO';
        
        $query_detalle = "INSERT INTO DETALLE_ORDEN (NO_ORDEN, PRODUCTO, CANTIDAD, NOTAS, ESTADO)
        VALUES ('$idorden', '$productoID', '$cantidad', '$notas', '$estado')";
        $conexion->ejecutarSQL($query_detalle);
    } 
}
?>
    <script src="../js/bootstrap.bundle.js"></script>
    </body>
</html>