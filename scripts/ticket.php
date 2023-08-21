<?php
require __DIR__ . '../../ticket/escpos-php/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

$db = new Database();
$db->conectarDB();
$orden = $_SESSION['orden1'];
$correo = $_SESSION['correo'];
$NOTASU = $_SESSION['notas'];
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
// Conectar con la impresora
$archivoTicket = 'ticket.txt';
$connector = new FilePrintConnector($archivoTicket);
$printer = new Printer($connector);

// Agregar contenido al ticket
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("===== Ticket de Compra =====\n");
$printer->feed(1);

$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Sucursal: $NOMBRES\n");
$printer->text("Direccion: $DIREC\n");
$printer->text("Telefono: $TEL\n");
$printer->feed(1);

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Fecha: $FECHA\n");
$printer->text("Cajero: $NOMBREU\n");
$printer->feed(1);

$printer->text("Notas: $NOTASU\n");
$printer->feed(1);

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Cant.     Precio     Total\n");
$printer->text("-------------------------------\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);

foreach($tabla as $info){
    $NOMBREP = $info->NOMBREP;
    $CANT = $info->CANTIDAD;
    $PRECIO = $info->PRECIO;
    $TOTALU = $info->TOTALU;
    $printer->text("$NOMBREP\n");
    $printer->text("Cant: $CANT   Precio: $$PRECIO   Subtotal: $$TOTALU\n");
}

$printer->text("-------------------------------\n");
$TOTAL = $info->TOTAL;
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("TOTAL A PAGAR\n");
$printer->text("$"."$TOTAL\n");
$printer->feed(2);

$printer->text("Gracias por su compra,\n");
$printer->text("su orden es: $orden\n");

// Finalizar la impresión
$printer->feed(2);
$printer->cut();
$printer->close();
?>