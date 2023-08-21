<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    include '../class/database.php';
    $conexion = new Database();
    $conexion->conectarDB();

    $fecha = date("Y-m-d"); 

    $id_usuario = $_SESSION["IDUSU"];

        $consulta_sucursal = "SELECT SUCURSAL FROM EMPLEADO_SUCURSAL WHERE EMPLEADO = '$id_usuario'";
        $resultado_sucursal = $conexion->seleccionar($consulta_sucursal);

        if ($resultado_sucursal && count($resultado_sucursal) > 0) 
        {
            $sucursal_id = $resultado_sucursal[0]->SUCURSAL;

            foreach ($_POST['cantidades'] as $nombre_insumo => $cantidad) {
                // Procesar el nombre del insumo para evitar inyección de SQL
                $nombre_insumo = $conexion->escapar($nombre_insumo);
                $nombre_insumo = str_replace("'", "\\'", $nombre_insumo); // Escapar comillas simples adicionales

                // Sanitizar la cantidad recibida
                $cantidad = ($conexion->escapar($cantidad)); 

                // Preparar la consulta para actualizar la tabla INV_SUC con un JOIN a la tabla INVENTARIO
                $consulta = "UPDATE INV_SUC
                             JOIN INVENTARIO ON INV_SUC.INVENTARIO = INVENTARIO.ID_INS
                             SET INV_SUC.CANTIDAD = $cantidad, INV_SUC.FECHA = '$fecha'
                             WHERE INVENTARIO.NOMBRE = '$nombre_insumo' AND INV_SUC.SUCURSAL = $sucursal_id";
                $conexion->ejecutarSQL($consulta);
            }
            $consulta="CALL RegistrarIngresosDiarios($sucursal_id);";
                $conexion->ejecutarSQL($consulta);
            header("Location: ExitoPV.php");
            exit();
        } else {
            echo "No se encontró la sucursal del empleado.";
        }
    }
?>