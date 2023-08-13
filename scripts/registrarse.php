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
        session_start();
        include '../class/database.php';
        $db = new Database();
        $db->conectarDB();
        extract($_POST);
        $_SESSION['BIENVENIDA']=$correo;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $cadena = "INSERT INTO USUARIOS(NOMBRE, DIRECCION, TELEFONO, CORREO, CONTRASENA, ROL, img_chidas, ESTADO)
        VALUES ('$nombre','$direccion','$telefono','$correo','$hash', 2, 'https://toys-pizza.s3.amazonaws.com/imagenes/usuariotoys.jpg', 'ACTIVO')";

        $db->ejecutarSQL($cadena);
        include'../Mail/IngresoMail.php';
        header("refresh:3 ../index.php");
        $db->desconectarDB();
        session_destroy();
        ?>
    </div>
</body>
</html>