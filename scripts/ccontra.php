<<?php 
include '../class/database.php';
$db = new Database();
$db->conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
            $correo = $_POST["correo"];
            $nueva_contrasena = $_POST["contrasena"];
            $confirmar_contrasena = $_POST["confirmar_contrasena"];
            echo $correo;
            // Verificar que las contraseñas coincidan
            if ($nueva_contrasena === $confirmar_contrasena) 
            {
                // Hashear la contraseña antes de guardarla en la base de datos
                $contrasena_hasheada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                // Realizar el UPDATE en la base de datos
                $consulta_update = "UPDATE USUARIOS SET CONTRASENA = '$contrasena_hasheada' WHERE CORREO = '$correo'";
                $db->ejecutarSQL($consulta_update);

                // Mostrar un mensaje de éxito
                header("Location: exitocontra.php");
                exit();
            } else {
                // Mostrar un mensaje de error si las contraseñas no coinciden
                ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
echo "<script>
alert('Las contraseñas no coinciden, vuelve a ingresar tu correo');
setTimeout(function() {
    window.location.href = '../views/olvidecontra.php';
}, 500); // 500 milisegundos = 0.5 segundos
</script>";
            }
        exit;
    } else {

    }
    ?>
