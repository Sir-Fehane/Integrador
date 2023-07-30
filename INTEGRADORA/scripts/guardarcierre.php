<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../class/database.php';
    $conexion = new Database();
    $conexion->conectarDB();

    $fecha = date("Y-m-d"); // Obtener la fecha actual

    $nombre_usuario = $_SESSION["usuario"];

    // Consultar la tabla USUARIOS para obtener el ID_USUARIO del usuario
    $consulta_usuario = "SELECT ID_USUARIO FROM USUARIOS WHERE NOMBRE = '$nombre_usuario'";
    $resultado_usuario = $conexion->seleccionar($consulta_usuario);

    if ($resultado_usuario && count($resultado_usuario) > 0) {
        $id_usuario = $resultado_usuario[0]->ID_USUARIO;

        // Consultar la tabla EMPLEADO_SUCURSAL para obtener el sucursal_id del empleado
        $consulta_sucursal = "SELECT SUCURSAL FROM EMPLEADO_SUCURSAL WHERE EMPLEADO = '$id_usuario'";
        $resultado_sucursal = $conexion->seleccionar($consulta_sucursal);

        if ($resultado_sucursal && count($resultado_sucursal) > 0) {
            $sucursal_id = $resultado_sucursal[0]->SUCURSAL;

            foreach ($_POST['cantidades'] as $nombre_insumo => $cantidad) {
                // Procesar el nombre del insumo para evitar inyección de SQL
                $nombre_insumo = $conexion->escapar($nombre_insumo);
                $nombre_insumo = str_replace("'", "\\'", $nombre_insumo); // Escapar comillas simples adicionales

                // Sanitizar la cantidad recibida
                $cantidad = intval($conexion->escapar($cantidad)); // Asegúrate de que sea un número entero

                // Preparar la consulta para actualizar la tabla INV_SUC con un JOIN a la tabla INVENTARIO
                $consulta = "UPDATE INV_SUC
                             JOIN INVENTARIO ON INV_SUC.INVENTARIO = INVENTARIO.ID_INS
                             SET INV_SUC.CANTIDAD = $cantidad, INV_SUC.FECHA = '$fecha'
                             WHERE INVENTARIO.NOMBRE = '$nombre_insumo' AND INV_SUC.SUCURSAL = $sucursal_id";

                $conexion->ejecutarSQL($consulta);
            }
            header("Location: ExitoPV.php");
            exit();
        } else {
            echo "No se encontró la sucursal del empleado.";
        }
    } else {
        echo "No se encontró el usuario con el nombre proporcionado.";
    }
}
?>


