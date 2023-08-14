<?php 
extract($_POST);
$orden=$_POST['noorden'];
include'../class/database.php';
$db=New Database();
$db->conectarDB();
$db->ejecutarSQL("UPDATE NOTIFICACIONES
SET ESTADO='RECIBIDO' WHERE ORDEN_VENTA=".$orden."");
?>