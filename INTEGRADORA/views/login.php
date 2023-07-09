<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Login Cliente</title>
</head>
<body>
    <div class="container">
        <?php
        include '../class/database.php';
        $db = new Database();
        $db->conectarDB();

        extract($_POST);

        $cadenaUsuarios = "SELECT NOMBRE, CONTRASEÑA FROM USUARIOS WHERE NOMBRE = '$usuario' AND CONTRASEÑA = '$password'";
        $cadenaEmpleados = "SELECT NOMBRE, CONTRASEÑA FROM EMPLEADOS WHERE NOMBRE = '$usuario' AND CONTRASEÑA = '$password'";

        $inicioUsuarios = false;
        $inicioEmpleados = false;

        $resultadoUsuarios = $db->loginUsuario($cadenaUsuarios)
        if ($resultadoUsuarios) 
        {
        $inicioUsuarios = true;
        } else 
        {
            $resultadoEmpleados = $db->loginUsuario($cadenaEmpleados);
            if ($resultadoEmpleados) 
            {
            $inicioEmpleados = true;
            }
        }

        if ($inicioUsuarios) {
            echo "<div class='alert alert-success'>Has iniciado sesión correctamente</div>";
            header("refresh:2 ../index.php");
        } else if($inicioEmpleados)
        {
            echo "<div class='alert alert-success'>Has iniciado sesión correctamente</div>";
            header("refresh:2 ../index.php");
        } else
        {
            echo "<div class='alert alert-danger'>Usuario y contraseña no encontrados</div>";
        }

        $db->desconectarDB();
        ?>
    </div>
</body>
</html>