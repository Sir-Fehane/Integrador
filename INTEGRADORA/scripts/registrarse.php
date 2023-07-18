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

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $cadena = "INSERT INTO USUARIOS(NOMBRE, DIRECCION, TELEFONO, CORREO, CONTRASEÑA, ROL)
        VALUES ('$nombre','$direccion','$celular','$correo','$hash', 2)";

        $db->ejecutarSQL($cadena);

        echo "<div class='alert alert-success'> Cliente Registrado</div>";
        header("refresh:3 ../index.php");

        $db->desconectarDB();
        ?>
    </div>
</body>
</html>