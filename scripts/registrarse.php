<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Registrar Cliente</title>
</head>
<body>
<div class="container">
        <?php
        include '../class/database.php';
        $db = new Database();
        $db->conectarDB();
        extract($_POST);
        require '../Mail/PHPMailer.php';
        require '../Mail/SMTP.php';
        require '../Mail/Exception.php';
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        $emailExists = $db->seleccionar("SELECT COUNT(*) as contador FROM USUARIOS WHERE CORREO = '$correo'");
        foreach($emailExists as $contador){}
$ccorreo = $contador->contador;
if ($ccorreo > 0) {
    
    echo "<script>alert('El correo ya está registrado.'); window.location.href = '../index.php';</script>";
    exit(); // Stop further execution
}

        $codigo_aleatorio = rand(100000, 999999);
        $hash = password_hash($password, PASSWORD_DEFAULT);
    $cadena = "INSERT INTO USUARIOS(NOMBRE, DIRECCION, TELEFONO, CORREO, CONTRASENA, ROL, img_chidas,NICKNAME,CODIGOC,ESTADO)
    VALUES ('$nombre','$direccion','$telefono','$correo','$hash', 2, 'https://toys-pizza.s3.amazonaws.com/imagenes/usuariotoys.jpg','','$codigo_aleatorio','INACTIVO')";
            $db->ejecutarSQL($cadena);
        // ... Código para recibir los datos del formulario y validarlos ...

            // Generar un código aleatorio
           
            // Enviar el código por correo electrónico
            $mail = new PHPMailer(true);
            
            // Configuración del servidor SMTP y demás ajustes
         
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'oscare.alvarado17@gmail.com';                     //Correo del don toys
    $mail->Password   = 'igybzfaahhtsbrmt';                               //la contra de la verificacion de 2 pasos
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';
    //Recipients
    $mail->setFrom('oscare.alvarado17@gmail.com', 'Don Toys');
    $mail->addAddress($correo);
    $mail->isHTML(true);   
            $mail->Subject = 'Código de verificación';
            $mail->Body = "Tu código de verificación es: $codigo_aleatorio";
        
            if ($mail->send()) {
                // Guardar el código en la base de datos o en algún lugar para futura verificación
                // Redirigir a una página para que el usuario ingrese el código

                echo "<form name='envia' method='POST' action='verificar_codigo.php'>
                <input type=hidden name=correo value=$correo>
                </form>
                <script language='JavaScript'>
                document.envia.submit()
                </script>";
                

            } 
        
        ?>
    </div>
</body>
</html>