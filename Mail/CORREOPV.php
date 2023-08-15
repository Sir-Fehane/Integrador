<?php
require "../fpdf/code128.php";
$db = new Database();
$db->conectarDB();
$orden = $_SESSION['orden1'];
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
$pdf->MultiCell(0,5,utf8_decode("Cajero: "."$NOMBREU"),0,'C',false);
$pdf->SetFont('Arial','B',10);
$pdf->SetFont('Arial','',9);

$pdf->Ln(1);
$pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
$pdf->Ln(3);

# Tabla de productos #
$pdf->Cell(10,5,utf8_decode("Cant."),0,0,'C');
$pdf->Cell(19,5,utf8_decode("Precio"),0,0,'C');
$pdf->Cell(28,5,utf8_decode("Total"),0,0,'C');

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


$nombreArchivo = "$orden.pdf";
$pdf->Output('F', $nombreArchivo);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Content-Length: ' . filesize($nombreArchivo));
readfile($nombreArchivo);

header("location: ../views/puntoventa.php");
exit();
?>

