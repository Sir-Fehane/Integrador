<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../img/fondocar.jpg');
            background-color: rgba(0, 0, 0, 0.5);
        }

        .container {
            margin-top: 100px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        .countdown-container {
            text-align: center;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-size: 15px;
        }
    </style>
    <title>Verificar Código</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <?php
                include '../class/database.php';
                $db = new Database();
                $db->conectarDB();
                require '../Mail/PHPMailer.php';
                require '../Mail/SMTP.php';
                require '../Mail/Exception.php';

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\SMTP;
                use PHPMailer\PHPMailer\Exception;

                $correo = "";

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $correo = $_POST['correo'];

                    if (isset($_POST['enviar_nuevo_codigo'])) 
                    {
                        echo "<script>alert('Hemos enviado un nuevo código a tu correo.');</script>";
                        // Generar un nuevo código aleatorio
                        $nuevo_codigo_aleatorio = rand(100000, 999999);
                
                        // Actualizar el nuevo código en la base de datos
                        $cadena_actualizar_codigo = "UPDATE USUARIOS SET CODIGOC = '$nuevo_codigo_aleatorio' WHERE CORREO = '$correo'";
                        $db->ejecutarsql($cadena_actualizar_codigo);        
                
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
                        $mail->Body = "Tu nuevo código de verificación es: $nuevo_codigo_aleatorio, por favor regrese a la página para activar su cuenta";
                    
                        if ($mail->send()) 
                        {
                            // Guardar el código en la base de datos o en algún lugar para futura verificación
                            // Redirigir a una página para que el usuario ingrese el código
                
                            echo "<form name='envia' method='POST' action='verificar_codigo.php'>
                            <input type=hidden name=correo value=$correo>
                            </form>
                            <script language='JavaScript'>
                            document.envia.submit()
                            </script>";
                        } 
                        // ... Código para enviar el correo y redirigir ...
                    } elseif (isset($_POST['codigo_ingresado'])) {
                        $codigo_ingresado = $_POST['codigo_ingresado'];

                        $consulta = "SELECT CODIGOC FROM USUARIOS WHERE CORREO = '$correo'";
                        $tabla = $db->seleccionar($consulta);

                        if ($tabla) {
                            $registro = reset($tabla); // Obtener el primer registro
                            $codigo = $registro->CODIGOC;
                            if ($codigo_ingresado == $codigo) {
                                // El código coincide, el proceso de registro está completo

                                $cadena = "UPDATE USUARIOS SET ESTADO = 'ACTIVADO' WHERE CORREO = '$correo'";
                                $db->ejecutarsql($cadena);
                                echo "<script>alert('El correo se ha verificado, su cuenta esta activada.'); window.location.href = '../index.php';</script>";
                                // Aquí puedes realizar la actualización del estado del usuario a "ACTIVO"
                                // Actualización de estado en la base de datos...
                            } else {
                                // El código no coincide
                                echo "<p class='error-message'>Código incorrecto. Inténtalo de nuevo.</p>";
                            }
                        } else {
                            echo "<p class='error-message'>No se pudo verificar el código. Intenta nuevamente más tarde.</p>";
                        }
                    }
                }
                ?>
        <!--Verificar código-->
        <form action="verificar_codigo.php" method="POST" class="needs-validation " novalidate style="width:90%">
            <input type="hidden" name="correo" value="<?php echo $correo; ?>">
            <div class="form-group">
                <label for="codigo_ingresado">Ingresa el código de verificación que hemos enviado al correo proporcionado:</label>
                <input type="text" name="codigo_ingresado" class="form-control" required>
                <div class="invalid-feedback">Por favor ingresa el código de verificación.</div>
            </div>
            <button type="submit" class="btn btn-warning">Verificar</button> <br>
        </form>
        <!--Enviar nuevo código-->
        <form action="verificar_codigo.php" method="POST" class="mt-3">
        <input type="hidden" name="correo" value="<?php echo $correo; ?>">
        <label for="#">No recibiste el código?</label> <span id="countdown">00:30</span>
        <button id="enviarNuevoCodigoButton" type="submit" name="enviar_nuevo_codigo" class="btn btn-link" disabled>Enviar nuevo código</button>
    </form>

    <!-- Agrega el enlace al archivo JS de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Agrega validación de formularios de Bootstrap
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Función para actualizar el temporizador
function updateCountdown() {
    var countdownElement = document.getElementById('countdown');
    var timeArray = countdownElement.innerHTML.split(':');
    var minutes = parseInt(timeArray[0]);
    var seconds = parseInt(timeArray[1]);

    if (minutes === 0 && seconds === 0) {
        // Habilitar el botón "Enviar nuevo código"
        var enviarNuevoCodigoButton = document.getElementById('enviarNuevoCodigoButton');
        enviarNuevoCodigoButton.disabled = false;
    } else {
        if (seconds === 0) {
            minutes--;
            seconds = 59;
        } else {
            seconds--;
        }

        // Actualizar el temporizador en la página
        countdownElement.innerHTML = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        // Actualizar el temporizador cada segundo
        setTimeout(updateCountdown, 1000);
    }
}

// Iniciar el temporizador al cargar la página
updateCountdown();
    </script>
</body>
</html>
