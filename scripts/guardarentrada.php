<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header('Location: ../index.php');
    exit;
} else {
    if ($_SESSION["rol"] == 2) {
        header("Location: ../index.php");
        exit;
    } elseif ($_SESSION["rol"] == 1) { 
        header("Location: admin.php");
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['cantidades']) && !empty($_POST['cantidades']) && isset($_POST['guardarSolicitud'])) {
        include '../class/database.php';
        $conexion = new database();
        $conexion->conectarDB();
        $id_usuario = $_SESSION["IDUSU"];

        $consulta_sucursal = "SELECT SUCURSAL FROM EMPLEADO_SUCURSAL WHERE EMPLEADO = '$id_usuario'";
        $resultado_sucursal = $conexion->seleccionar($consulta_sucursal);

        if ($resultado_sucursal && count($resultado_sucursal) > 0) {
            $sucursal_id = $resultado_sucursal[0]->SUCURSAL;

            foreach ($_POST['cantidades'] as $idSolicitud => $insumos) {
                foreach ($insumos as $nombreInsumo => $cantidadNueva) {
                    // Obtén el ID del insumo basado en el nombre
                    $consultaIdInsumo = "SELECT ID_INS FROM INVENTARIO WHERE NOMBRE = '$nombreInsumo'";
                    $resultadoIdInsumo = $conexion->seleccionar($consultaIdInsumo);
                    $idInsumo = $resultadoIdInsumo[0]->ID_INS;

                    // Obtén la cantidad existente del insumo en INV_SUC
                    $consultaCantidadExistente = "SELECT CANTIDAD FROM INV_SUC WHERE INVENTARIO = $idInsumo AND SUCURSAL = $sucursal_id";
                    $resultadoCantidadExistente = $conexion->seleccionar($consultaCantidadExistente);
                    $cantidadExistente = $resultadoCantidadExistente[0]->CANTIDAD;

                    // Calcula la nueva cantidad
                    $nuevaCantidad = $cantidadExistente + $cantidadNueva;

                    // Realiza la actualización en INV_SUC
                    $actualizacion = "UPDATE INV_SUC SET CANTIDAD = $nuevaCantidad, FECHA = NOW() WHERE INVENTARIO = $idInsumo AND SUCURSAL = $sucursal_id";
                    $conexion->ejecutarSQL($actualizacion);
                }

                // Actualiza el estado en SOLICITUDES
                $nuevoEstado = 'recibido';
                $actualizacionSolicitudes = "UPDATE SOLICITUDES SET ESTADO = '$nuevoEstado' WHERE ID_SOLICITUD = $idSolicitud";
                $conexion->ejecutarSQL($actualizacionSolicitudes);
            }

            header("Location: Esoli.php");
        } else {
            echo "No se recibieron datos válidos.";
        }
    }
}

?>