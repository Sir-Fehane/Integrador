<?php
require "../fpdf/code128.php";
include "../carrito/Cart.php";
include '../class/database.php';
$db = new Database();
$db->conectarDB();
$orden = $_SESSION['orden'];
$correo = $_SESSION['correo'];
$ordenesact = "SELECT OV.TOTAL,DE.NO_ORDEN, P.NOMBRE AS NOMBREP, DE.CANTIDAD,P.PRECIO, P.PRECIO * DE.CANTIDAD AS TOTALU, S.NOMBRE,S.TELEFONO,S.DIRECCION FROM ORDEN_VENTA OV 
INNER JOIN USUARIOS U ON U.ID_USUARIO = OV.USUARIO
INNER JOIN SUCURSALES S ON S.ID_SUC = OV.SUCURSAL
INNER JOIN DETALLE_ORDEN DE ON DE.NO_ORDEN = OV.NO_ORDEN 
INNER JOIN PRODUCTOS P ON DE.PRODUCTO = P.CODIGO
WHERE OV.NO_ORDEN = $orden";
$ordenesact1 = "SELECT OV.HORA_FECHA, OV.TOTAL,DE.NO_ORDEN, P.NOMBRE AS NOMBREP, DE.CANTIDAD,P.PRECIO, P.PRECIO * DE.CANTIDAD AS TOTALU, S.NOMBRE AS NOMBRES,S.TELEFONO,S.DIRECCION, U.NOMBRE, U.DIRECCION AS DIRECCIONU, U.TELEFONO AS TELEFONOU
FROM ORDEN_VENTA OV 
INNER JOIN USUARIOS U ON U.ID_USUARIO = OV.USUARIO
INNER JOIN SUCURSALES S ON S.ID_SUC = OV.SUCURSAL
INNER JOIN DETALLE_ORDEN DE ON DE.NO_ORDEN = OV.NO_ORDEN 
INNER JOIN PRODUCTOS P ON DE.PRODUCTO = P.CODIGO
WHERE OV.NO_ORDEN = $orden";
$tabla = $db->seleccionar($ordenesact);
$tabla1 = $db->seleccionar($ordenesact1);
foreach($tabla1 as $info1){}
$DIREC = $info1->DIRECCION;
$TEL = $info1->TELEFONO;
$NOMBRES = $info1->NOMBRES;
$NOMBREU = $info1->NOMBRE;
$TELEFONOU = $info1->TELEFONOU;
$DIRECCIONU = $info1->DIRECCIONU;
$FECHA = $info1->HORA_FECHA;
// Crea un nuevo objeto FPDF
$pdf = new PDF_Code128('P','mm',array(80,258));

// Agrega una página
$pdf->SetMargins(4,10,4);
$pdf->AddPage();

# Encabezado y datos de la empresa #
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,5,utf8_decode(strtoupper("Toys pizza")),0,'C',false);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode("Sucursal:"."$NOMBRES"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Direccion: "."$DIREC"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Teléfono: "."$TEL"),0,'C',false);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
$pdf->Ln(5);
$pdf->MultiCell(0,5,utf8_decode("Fecha: "."$FECHA"),0,'C',false);
$pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
$pdf->Ln(5);

$pdf->MultiCell(0,5,utf8_decode("Cliente: "."$NOMBREU"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Teléfono: "."$TELEFONOU"),0,'C',false);
$pdf->MultiCell(0,5,utf8_decode("Dirección: "."$DIRECCIONU"),0,'C',false);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);

# Tabla de productos #
$pdf->Cell(10,5,utf8_decode("Cant."),0,0,'C');
$pdf->Cell(19,5,utf8_decode("Precio"),0,0,'C');
$pdf->Cell(28,5,utf8_decode("Subtotal"),0,0,'C');

$pdf->Ln(3);
$pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);



/*----------  Detalles de la tabla  ----------*/

foreach($tabla as $info){
    $NOMBREP = $info->NOMBREP;
    $CANT = $info->CANTIDAD;
    $PRECIO = $info->PRECIO;
    $TOTALU = $info->TOTALU;
    $pdf->MultiCell(0,4,utf8_decode("$NOMBREP"),0,'C',false);
    $pdf->Cell(10,4,utf8_decode("$CANT"),0,0,'C');
    $pdf->Cell(19,4,utf8_decode("$"."$PRECIO"."MX"),0,0,'C');
    $pdf->Cell(28,4,utf8_decode("$"."$TOTALU"."MX"),0,0,'C');
    $pdf->Ln(7);
}



/*----------  Fin Detalles de la tabla  ----------*/



$TOTAL = $info->TOTAL;
$pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

$pdf->Ln(5);
$pdf->Cell(18,5,utf8_decode(""),0,0,'C');
$pdf->Cell(22,5,utf8_decode("TOTAL A PAGAR"),0,0,'C');
$pdf->Cell(32,5,utf8_decode("$"."$TOTAL".".00"),0,0,'C');

$pdf->Ln(10);


$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,7,utf8_decode("Gracias por su compra, su orden es: "." $orden" ),'',0,'C');

$pdf->Ln(9);

// Salida del PDF
$pdf->Output('F','mi_pdf.pdf');
?>

<?php
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
    $mail->Body    =  'Pon esto shulo Isaac' ;
   //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}