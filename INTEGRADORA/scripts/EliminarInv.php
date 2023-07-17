<?php
if(isset($_POST['eliminar']))
{
    include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
    extract($_POST);
    $cadena = "UPDATE INVENTARIO SET ESTADO = 'INACTIVO' WHERE ID_INS = $id";
    $db->ejecutarsql($cadena);
    $db->desconectarDB();
    echo "SI QUEDO";
}
?>