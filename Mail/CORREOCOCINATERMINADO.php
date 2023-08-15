<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'oscare.alvarado17@gmail.com';                     //Correo del don toys
    $mail->Password   = 'igybzfaahhtsbrmt';                               //la contra de la verificacion de 2 pasos
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('oscare.alvarado17@gmail.com', 'Don Toys');
    $mail->addAddress($_SESSION['CORREO']);
    $mail->isHTML(true); 
    try {
        $mail->Subject = 'PEDIDO TERMINADO';//Poner diseño a esta cosa, pues es lo que se verá
        $mail->Body    =  'Su pedido ha sido terminado, favor de recoger en sucursal.' ;
      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
      echo "<h1> PEDIDO MARCADO COMO TERMINADO </h1>";
      header('refresh:5 ; ../views/pendientes.php');
    }
    catch (Exception $e)
    {
      echo "Sucedió un error inesperado. Error: {$mail->ErrorInfo}";
    }
?>