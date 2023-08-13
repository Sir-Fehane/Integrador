<?php
/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////
include"../class/database.php";
$db=New Database();
$db->conectarDB();
//Consulta para mostrar las notificaciones pendientes en la campana
$CONSNUMNOT=$db->seleccionar("SELECT COUNT(ID_NOT) AS 'NOT' FROM NOTIFICACIONES WHERE ID_SUC=2 AND ESTADO='PENDIENTE'");

///TABLA DONDE SE DESPLIEGAN LOS REGISTROS //////////////////////////////
foreach($CONSNUMNOT as $x)
{
echo $x->NOT;
}
?>