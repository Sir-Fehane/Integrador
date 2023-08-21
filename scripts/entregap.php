<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
<?php 
include'../class/database.php';
$db=New Database();
$db->conectarDB();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../Mail/Exception.php';
require '../Mail/PHPMailer.php';
require '../Mail/SMTP.php';
extract($_POST);

$correo=$_POST['correo'];
$orden=$_POST['noorder'];
$estado=$_POST['OV'];
$chequeo=$db->seleccionar("SELECT OV.ESTADO FROM ORDEN_VENTA OV WHERE OV.NO_ORDEN=".$orden."");
      foreach($chequeo as $x)
      {
        $notecreasxd = $x->ESTADO;
      }

if($notecreasxd =='TERMINADO')
{
//Create an instance; passing `true` enables exceptions


    //Server settings
    $db->ejecutarSQL("UPDATE ORDEN_VENTA
    SET ESTADO='".$estado."' WHERE ORDEN_VENTA.NO_ORDEN=".$orden."");
   echo "<div class='container mt-5 d-flex justify-content-center'>
    <div class='alert alert-success'>
        <i class='bx bxs-check-circle'></i>
        <strong>Proceso terminado</strong><br>
        <div class='d-flex justify-content-center'>
          <div class='spinner-border text-success' role='status'>
            <span class='visually-hidden'>Loading...</span>
          </div>
        </div>
        
      </div>
    </div>";

    header('refresh:2 ; ../views/terminadas.php');

}
else
{
echo "<h1>PEDIDO YA RECIBIDO, FAVOR DE ESCOGER OTRO</h1>";
header('../views/terminadas.php');
}

?>   
 <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
