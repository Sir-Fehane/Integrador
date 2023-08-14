<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/boot.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body style="background-color: #D6CFCF;">
<?php
include '../class/database.php';
$db = new Database();
$db->conectarDB();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
  if(isset($_POST['codigo_ingresado'])){
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
            echo "Código incorrecto. Inténtalo de nuevo.";
        }
    } else {
        echo "No se pudo verificar el código. Intenta nuevamente más tarde.";
    }
}
}
?>

<div class="container mt-5 shadow p-3 mb-5 rounded" style="width: 60%;  height: 30%; background-color:white" >
        <form action="verificar_codigo.php" method="POST" class="needs-validation " novalidate style="width:90%">
            <input type="hidden" name="correo" value="<?php echo $correo; ?>">
            
            <div class="form-group">
                <label for="codigo_ingresado">Ingresa el código de verificación:</label>
                <input type="text" name="codigo_ingresado" class="form-control" required>
                <div class="invalid-feedback">Por favor ingresa el código de verificación.</div>
            </div>
            
            <button type="submit" class="btn btn-warning">Verificar</button>
        </form>
    </div>

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
    </script>
</body>
</html>