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
    $messageR  = "<!DOCTYPE html>
    <html>
    <body style='background-color:#f2f2f2;'>
    <div style='width: 100%; height: 10%; background-color: #BB0E10;' >
    <h1 style='color: #FECB00'>Toys Pizza</h1></div>
    <div>
            <h1 style='color: #2A52D5' align='center'>Pedido recibido</h1><br>
            <h3 style='color: #2A52D5' align='center'>¡En hora buena!</h3>
            <P style='color: #2A52D5' align='center'>Su pedido ya ha pasado nuestra cocina, en unos momentos ya estará lista.
            </P>
          </div>
    </body>
    </html>
 "; 
    $mail->Body    =  $messageR ;
   //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    }
    else
    {
        $messageC  = "<!DOCTYPE html>
        <html>
        <body style='background-color:#f2f2f2;'>
        <div style='width: 100%; height: 10%; background-color: #BB0E10;' >
        <h1 style='color: #FECB00'>Toys Pizza</h1></div>
        <div>
                <h1 style='color: #2A52D5' align='center'>Pedido cancelado</h1><br>
                <h3 style='color: #2A52D5' align='center'>Lo sentimos...</h3>
                <P style='color: #2A52D5' align='center'>Su orden ha sido cancelada, favor de comunicarse para saber que sucedió...
                </P>
              </div>
        </body>
        </html>
     "; 
        $mail->Subject = 'PEDIDO CANCELADO';//Poner diseño a esta cosa, pues es lo que se verá
        $mail->Body    = $messageC ;
       //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
    }
    header('refresh:0 ; ../views/pendientes.php');
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