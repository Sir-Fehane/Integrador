<?php 
include '../class/database.php';
$db = new Database();
$db->conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo_ingresado"])) 
{
    $correo = $_POST["correo"];
    $codigo_ingresado = $_POST["codigo_ingresado"];
    $codigo_aleatorio = $_POST["codigo_aleatorio"];

    if ($codigo_ingresado == $codigo_aleatorio) 
    {
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
    <title>Cambiar Contraseña</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <h4>Ingresa tu nueva contraseña</h4>
                <form method="post" action="../scripts/ccontra.php">
                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label>
                        <input placeholder="8 o más caracteres" type="password" name="contrasena" class="form-control custom-input" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                        <input type="password" name="confirmar_contrasena" class="form-control custom-input" required minlength="8">
                        <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Agrega el enlace al archivo JS de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php

}else{
// Los códigos no coinciden, muestra un mensaje de error
echo "<script>
        alert('Código no válido, vuelve a ingresar tu correo');
        setTimeout(function() {
            window.location.href = '../views/olvidecontra.php';
        }, 500); // 500 milisegundos = 0.5 segundos
      </script>";
}        
}
?>
</body>
</html>
