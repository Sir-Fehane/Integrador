<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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

        .error-message {
            color: red;
            font-size: 15px;
        }
        .text-success {
            color: green;
        }
        .custom-input {
            border: 2px solid #808080; /* Color del borde */
        }
    </style>
    <title>Recuperar mi contraseña</title>
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
                
                // Parte 1: Generar y enviar el código de verificación
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["correo"])) 
                {
                    $correo = $_POST["correo"];

                    // Verificar si el correo existe en la base de datos
                    $consulta = "SELECT COUNT(*) AS count FROM USUARIOS WHERE CORREO = '$correo' AND ESTADO = 'ACTIVADO'";
                    $resultado = $db->seleccionar($consulta);

                    if ($resultado > 0) 
                    {
                        $registro = reset($resultado);
                        $count = $registro->count;

                        if ($count > 0) 
                        {
                            // Generar un código de verificación
                            $codigo_aleatorio = rand(100000, 999999);

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


                            // Mostrar mensaje de éxito
                            echo "<p class='text-success'>Se ha enviado un código de verificación a su correo electrónico.</p>";
                            // Mostrar mensaje de éxito
                        } else {
                            // El correo no existe en la base de datos
                            echo "<p class='error-message'>El correo ingresado no está registrado.</p>";
                        }
                    } else {
                        // Error al verificar el correo en la base de datos
                        echo "<p class='error-message'>Ha ocurrido un error. Inténtalo nuevamente más tarde.</p>";
                    }
            }
                ?>
                <form method="post" action="">
                    <h4>Ingresa el correo asociado a tu cuenta:</h4>
                    <label for="#">Enviaremos un código de verificación para que puedas recuperar tu contraseña</label>
                    <br><br>
                    <input type="email" id="correo" name="correo" class="form-control custom-input" required><br>
                    <button type="submit" class="btn btn-primary"id="bloqueo" onclick="cambiarContenido()">Enviar</button>
                </form>

                <!-- Modal para ingresar código de verificación -->
                <div class="modal fade" id="codigoModal" tabindex="-1" role="dialog" aria-labelledby="codigoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="codigoModalLabel">Código de verificación</h5>
                            </div>
                            <div class="modal-body">
                                <form id="codigoForm" method="post" action="Cambiarcontra.php">
                                    <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                                    <input type="hidden" name="codigo_aleatorio" value="<?php echo $codigo_aleatorio; ?>">
                                    <div class="form-group">
                                        <label for="codigo_ingresado">Ingresa el código que hemos enviado a tu correo:</label>
                                        <input type="text" name="codigo_ingresado" class="form-control custom-input" required>
                                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary" id="submitCodigo">Aceptar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agrega el enlace al archivo JS de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
        <script>
        $(document).ready(function() {
            <?php
            // Mostrar el modal si se envió el código exitosamente
            if (isset($mail) && $mail->send()) {
                echo "$('#codigoModal').modal('show');";
            }
            ?>
        });
        document.addEventListener("DOMContentLoaded", function() 
        {
    var boton = document.getElementById("bloqueo");
    var form = document.querySelector("form");

    form.addEventListener("submit", function() 
    {
        boton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...';
        boton.disabled = true;
    });
});
    </script>
</body>
</html>
