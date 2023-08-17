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
    try
    {
      extract($_POST);
      $cadena = "UPDATE SUCURSALES SET ESTADO = 'INACTIVO' WHERE ID_SUC = $suc;";
      $db->ejecutarsql($cadena);
      $db->desconectarDB();
      header("Location: Exito.php");
      exit;
    }
    catch(PDOException $e) 
    {
      $error_message = "Error al ejecutar la acción.";
      $error_code = $e->getCode();          
      if ($error_code === "23000") 
        {
            $error_message = "No se puede eliminar este registro debido a restricciones de integridad referencial.";
        }
      header("Location: Fallo.php?error_message=" . urlencode($error_message));
    }
  }
?>