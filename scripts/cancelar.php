<?php
session_start();
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
}
else
 {
  if ($_SESSION["rol"] == 1) {
    header("Location: ../admin.php");
    exit;
  } elseif ($_SESSION["rol"] == 3) { 
    header("Location: puntoventa.php");
    exit;
  }
 }
if(isset($_POST['eliminar']))
{
    include "../class/database.php";
        $db = new Database();
        $db->conectarDB();
    extract($_POST);
    $cadena = "UPDATE ORDEN_VENTA SET ESTADO = 'CANCELADA' WHERE NO_ORDEN = $id";
    $db->ejecutarsql($cadena);
    $db->desconectarDB();
    header("Location: ../views/mispedidos.php");
    exit;
}
?>