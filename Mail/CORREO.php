<?php
include "../class/database.php";
include "../carrito/Cart.php";
$db = new Database();
$db->conectarDB();
$orden = $_SESSION['orden'];
$correo = $_SESSION['correo'];
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
// HTML email starts here
   
   $message  = "<!DOCTYPE html>
   <html>
   <body style='background-color:#f2f2f2;'>
   <div style='width: 100%; height: 10%; background-color: #BB0E10;' >
   <h1 style='color: #FECB00'>Toys Pizza</h1></div>
   <div>
           <h1 style='color: #2A52D5' align='center'>Pedido confirmado</h1><br>
           <h2 style='color: #2A52D5' align='center'>Su orden es # $orden</h2>
           <h3 style='color: #2A52D5' align='center'>¡Gracias por ordenar!</h3>
           <P style='color: #2A52D5' align='center'>Lo mantendremos al pendiente con su orden mediante el correo, también, puede ver sus<br>pedidos en la pestaña ver pedidos.
           </P>
         </div>
   </body>
   </html>
";   
try {
    //Server settings
   
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
    $mail->isHTML(true);                                  //Poner diseño a esta cosa, pues es lo que se verá
    $mail->Subject = 'PEDIDO CONFIRMADO';
    $mail->Body    =  $message ;
   //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>