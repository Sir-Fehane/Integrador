<?php
session_start();
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
}
else
 {
  if ($_SESSION["rol"] == 2) {
    header("Location: ../index.php");
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
    $cadena = "UPDATE EMPLEADO_SUCURSAL SET ESTADO = 'INACTIVO' WHERE EMPLEADO = $id";
    $db->ejecutarsql($cadena);
    $db->desconectarDB();
    header("Location: Exito.php");
    exit;
}
?>