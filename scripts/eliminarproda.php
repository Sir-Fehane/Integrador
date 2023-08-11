<?php
if(isset($_POST['eliminar']))
{
    include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
    extract($_POST);
    $cadena = "UPDATE PRODUCTOS SET ESTADO = 'INACTIVO' WHERE CODIGO = $COD";
    $db->ejecutarsql($cadena);
    $db->desconectarDB();
    header("Location: Exito.php");
    exit;
}
?>