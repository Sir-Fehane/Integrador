<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['insumosSeleccionados']) && isset($_POST['cantidad'])) 
    {
        $insumos = $_POST['insumosSeleccionados'];
        $cantidades = $_POST['cantidad'];

        //echo "Cantidad de insumos: " . count($insumos) . "<br>";
        //echo "Cantidad de cantidades: " . count($cantidades) . "<br>";

        //echo "Arreglo de insumos:<br>";
        //var_dump($insumos);

        //echo "Arreglo de cantidades:<br>";
        //var_dump($cantidades);

        if (count($insumos) === count($cantidades)) 
        {
            include "../class/database.php";
            $db = new Database();
            $db->conectarDB();

            $nombre_usuario = $_SESSION["usuario"];
            $consulta_usuario = "SELECT ID_USUARIO FROM USUARIOS WHERE NOMBRE = '$nombre_usuario'";
            $resultado_usuario = $db->seleccionar($consulta_usuario);

            if ($resultado_usuario && count($resultado_usuario) > 0) 
            {
                $id_usuario = $resultado_usuario[0]->ID_USUARIO;

            $consulta_sucursal = "SELECT SUCURSAL FROM EMPLEADO_SUCURSAL WHERE EMPLEADO = '$id_usuario'";
            $resultado_sucursal = $db->seleccionar($consulta_sucursal);

            if ($resultado_sucursal && count($resultado_sucursal) > 0) 
            {
                $sucursal_id = $resultado_sucursal[0]->SUCURSAL;

                $fecha = date("Y-m-d H:i:s");

                //Insertar en SOLICITUDES
                $consulta = "INSERT INTO SOLICITUDES (SUCURSAL, ESTADO, FECHA) VALUES ($sucursal_id, 'SOLICITADO', '$fecha')";
                $db->ejecutarSQL($consulta);

                for ($i = 0; $i < count($insumos); $i++) 
                {
                    $cantidad = $cantidades[$indice];
                    {
                    $consulta_solicitud = "SELECT ID_SOLICITUD FROM SOLICITUDES WHERE SUCURSAL = $sucursal_id AND FECHA = '$fecha'";
                    $resultado_solicitud = $db->seleccionar($consulta_solicitud);

                    if($resultado_solicitud && count($resultado_solicitud) > 0)
                    {
                        $solicitud_id = $resultado_solicitud[0]->ID_SOLICITUD;
                    
                    $insumo = $insumos[$i];
                    $cantidad = $cantidades[$i];

                    $consultai = "SELECT INVENTARIO.ID_INS FROM INVENTARIO WHERE INVENTARIO.NOMBRE = '$insumo'";
                    $resultado_i = $db->seleccionar($consultai);
                    if ($resultado_i && count($resultado_i) > 0) 
                        {
                        $id_insumo = $resultado_i[0]->ID_INS;

                    //Insertar en DETALLE_SOLICITUD
                    $consulta = "INSERT INTO DETALLE_SOLICITUD (SOLICITUD, INVENTARIO, CANTIDAD) 
                    VALUES ('$solicitud_id', '$id_insumo', '$cantidad')";
                    $db->ejecutarSQL($consulta);
                        }
                    }
                    }
                }
            }
                $db->desconectarDB();
                header("Location: ExitoPV.php");
            exit();
            }
        } else 
        {
            echo "Los arreglos 'insumo' y 'cantidad' no tienen la misma cantidad de elementos.";
        }
    }
}
?>