<?php
session_start();
/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////
include"../class/database.php";
$db=New Database();
$db->conectarDB();
//Consulta para mostrar las notificaciones pendientes en la campana
$CONSNUMNOT=$db->seleccionar("SELECT COUNT(NO_ORDEN) AS 'NOT' FROM ORDEN_VENTA WHERE SUCURSAL=".$_SESSION['IDSUCUR']." AND ESTADO='TERMINADO'");

///TABLA DONDE SE DESPLIEGAN LOS REGISTROS //////////////////////////////
foreach($CONSNUMNOT as $x)
{
echo $x->NOT;
}
?>