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
$notid=$_POST['noti'];
$correo=$_POST['correo'];
$orden=$_POST['noorder'];
$estado=$_POST['OV'];
$chequeo=$db->seleccionar("SELECT NOTIFICACIONES.ESTADO FROM NOTIFICACIONES WHERE NOTIFICACIONES.ID_NOT=".$notid."");
      foreach($chequeo as $x)
      {
        $notecreasxd = $x->ESTADO;
      }
if($notecreasxd =='PENDIENTE')
{
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $db->ejecutarSQL("UPDATE NOTIFICACIONES
    SET ESTADO='RECIBIDO' WHERE NOTIFICACIONES.NUM_ORDEN=".$orden."");  
    $db->ejecutarSQL("UPDATE ORDEN_VENTA
    SET ESTADO='".$estado."' WHERE ORDEN_VENTA.NO_ORDEN=".$orden."");
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'oscare.alvarado17@gmail.com';                     //Correo del don toys
    $mail->Password   = 'igybzfaahhtsbrmt';                               //la contra de la verificacion de 2 pasos
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('oscare.alvarado17@gmail.com', 'Don Toys');
    $mail->addAddress($correo);     //La direccion a la cual se va a mandar
                 //Name is optional

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);     
    if($estado == 'EN PROCESO')
    {                  
    $mail->Subject = 'PEDIDO RECIBIDO';//Poner diseño a esta cosa, pues es lo que se verá
    $mail->Body    =  'Su pedido ha sido recibido, favor de estar al pendiente de más actualizaciones.' ;
   //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo "<h1> PEDIDO RECIBIDO </h1>";
    }
    else
    {
        $mail->Subject = 'PEDIDO CANCELADO';//Poner diseño a esta cosa, pues es lo que se verá
        $mail->Body    =  'Su pedido ha sido cancelado, favor de comunicarse para saber que ocurrió.' ;
       //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        echo "<h1> PEDIDO CANCELADO </h1>";
    }
    header('refresh:5 ; ../views/pendientes.php');
} catch (Exception $e) {
    echo "Sucedió un error inesperado. Error: {$mail->ErrorInfo}";
}
}
else
{
echo "<h1>PEDIDO YA RECIBIDO, FAVOR DE ESCOGER OTRO</h1>";
header('../views/pendientes.php');
}
?>