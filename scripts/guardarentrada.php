<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['insumosSeleccionados']) && isset($_POST['cantidad'])) 
    {
        $insumos = $_POST['insumosSeleccionados'];
        $cantidades = $_POST['cantidad'];

        if (count($insumos) === count($cantidades)) 
        {
            include "../class/database.php";
            $db = new Database();
            $db->conectarDB();

            $id_usuario = $_SESSION["IDUSU"];

            $consulta_sucursal = "SELECT SUCURSAL FROM EMPLEADO_SUCURSAL WHERE EMPLEADO = '$id_usuario'";
            $resultado_sucursal = $db->seleccionar($consulta_sucursal);

            if ($resultado_sucursal && count($resultado_sucursal) > 0) 
            {
                $sucursal_id = $resultado_sucursal[0]->SUCURSAL;

                foreach ($insumos as $indice => $nombreInsumo) 
                {
                    // Id insumo
                    $consultaIdInsumo = "SELECT ID_INS FROM INVENTARIO WHERE NOMBRE = '$nombreInsumo'";
                    $resultadoIdInsumo = $db->seleccionar($consultaIdInsumo);
                    $idInsumo = $resultadoIdInsumo[0]->ID_INS;

                    // Cantidad existente
                    $consultaCantidadExistente = "SELECT CANTIDAD FROM INV_SUC WHERE INVENTARIO = $idInsumo AND SUCURSAL = $sucursal_id";
                    $resultadoCantidadExistente = $db->seleccionar($consultaCantidadExistente);
                    $cantidadExistente = $resultadoCantidadExistente[0]->CANTIDAD;

                    // Cantidad nueva
                    $nuevaCantidad = $cantidadExistente + $cantidades[$indice];

                    $actualizarinv = "UPDATE INV_SUC SET CANTIDAD = $nuevaCantidad, FECHA = NOW() WHERE INVENTARIO = $idInsumo AND SUCURSAL = $sucursal_id";
                    $db->ejecutarSQL($actualizarinv);
                }
                header("Location: ExitoPV.php");
            }
            echo "No se encontró la sucursal";
        }
    }
    echo "No se encontraron los datos";
}
?>