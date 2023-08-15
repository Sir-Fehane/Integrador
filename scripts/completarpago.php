<?php
session_start();
include '../class/database.php';
$conexion = new database();
$conexion->conectarDB();
$cajero = $_SESSION['IDUSU'];
$formaPago = isset($_POST['forma_pago']) ? $_POST['forma_pago'] : '';
$tipoPedido = isset($_POST['tipo_pedido']) ? $_POST['tipo_pedido'] : '';    
$totalGeneral = isset($_POST['totalfinal']) ? $_POST['totalfinal'] : 0;
$notas = isset($_POST['notas']) ? $_POST['notas'] : '';   
$cajero = $_SESSION['IDUSU'];

$consulta_usuario = "SELECT NOMBRE FROM USUARIOS WHERE ID_USUARIO = '$cajero'";
$resultado_usuario = $conexion->seleccionar($consulta_usuario);

if (isset($_POST['pagar'])) {
    if ($resultado_usuario && count($resultado_usuario) > 0) {
        // consulta para saber a que sucursal va(innecesaria porque es un punto de venta y literalmente esta en sucursal pero para algo debe servir, yo creo xD)
        $consulta_sucursal = "SELECT SUCURSALES.NOMBRE AS SN, SUCURSALES.ID_SUC AS IDSUC FROM SUCURSALES INNER JOIN EMPLEADO_SUCURSAL ON SUCURSAL = SUCURSALES.ID_SUC WHERE EMPLEADO = $cajero";
        $resultado_sucursal = $conexion->seleccionar($consulta_sucursal);

        if ($resultado_sucursal && count($resultado_sucursal) > 0) {
            $sucursal_id = $resultado_sucursal[0]->IDSUC;

            // mete la orden a la tabla
            $estado = 'EN PROCESO';
            $query_orden = "INSERT INTO ORDEN_VENTA (USUARIO, TIPO, TOTAL, FORMA_PAGO, SUCURSAL, HORA_FECHA, ESTADO)
            VALUES ('$cajero', '$tipoPedido', '$totalGeneral', '$formaPago', '$sucursal_id', NOW(), '$estado')";
            
            $conexion->ejecutarSQL($query_orden);

            // saca el ultimo numero de orden
            $idorden = 0;
            $Orden = "SELECT MAX(NO_ORDEN) as IDO FROM ORDEN_VENTA WHERE SUCURSAL = '$sucursal_id' AND HORA_FECHA = NOW()";
            $noOrden = $conexion->selec($Orden);
            print_r($noOrden);
            foreach($noOrden as $OV){
                $idorden = $OV['IDO']; 
                if($idorden == 0){
                    $idorden = 1;
                } 
            }
            //Inserta datos a detalle orden
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $producto) {
                    $productoID = $producto['ID'];
                    $cantidad = $producto['cantidad'];
                    
                    $query_detalle = "INSERT INTO DETALLE_ORDEN (NO_ORDEN, PRODUCTO, CANTIDAD, NOTAS)
                    VALUES ('$idorden', '$productoID', '$cantidad', '$notas')";
                    
                    $conexion->ejecutarSQL($query_detalle);
                }
            } else {
                echo "El carrito está vacío.";
            }
        } else {
            echo "No se encontró la sucursal del empleado.";
        }
    }
    unset($_SESSION['carrito']);
}
header("Location: ../views/puntoventa.php");
exit();
?>