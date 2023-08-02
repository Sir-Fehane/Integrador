<?php 
class Database{
    private $PDOAws;
    private $user = "admin";
    private $password = "buenasnoches123,-";
    private $server = "mysql:host=toys-pizzadb.crljnq1eyagb.us-east-1.rds.amazonaws.com; dbname=BDTOYS";
    function conectarDB()
    {
        try
        {
            $this->PDOAws= new PDO($this->server, $this->user, $this->password);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    function desconectarDB()
    {
        try
        {
            $this->PDOAws= null;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function seleccionar($consulta)
    {
        try
        {
            $resultado = $this->PDOAws->query($consulta);
            $fila = $resultado->fetchAll(PDO::FETCH_OBJ);
            return $fila;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function ejecutarSQL($consulta)
    {
        try
        {
            $this->PDOAws->query($consulta);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    function verifica($usuario, $contra)
    {
        try
        {
            $pase = false;
            $query = "SELECT * FROM USUARIOS WHERE NOMBRE = '$usuario'";
            $consulta = $this->PDOAws->query($query);
            
            while($renglon = $consulta->fetch(PDO::FETCH_ASSOC))
            {
                if (password_verify($contra, $renglon['CONTRASEÑA'])) 
                {
                    $pase = true;
                    $rol = $renglon['ROL'];
                    $id_usuar=$renglon['ID_USUARIO'];
                }
            }
            if($pase)
            {
                session_start();
                $_SESSION["usuario"] = $usuario;
                $_SESSION["rol"] = $rol;
                $_SESSION["IDUSU"]= $id_usuar;

                echo "<div class = 'alert altert-success'>";
                echo "<h2 align = 'center'>Bienvenido ".$_SESSION["usuario"]."</h2> </div>";
                echo "</div>";

                switch ($_SESSION["rol"])
                {
                    case 1: header("location: ../views/admin.php");
                        break;
                    case 2: header("refresh:2 ../index.php");
                        break;
                    case 3: header("location: ../views/punto-de-venta.php");
                        break;
                    default:
                        break;
                }
            }
            else
            {
                echo "<div class = 'alert altert-danger'>";
                echo "<h2 align = 'center'>Usuario o password incorrecto</h2>";
                echo "</div>";
                header("refresh:2 ../index.php");
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    function cerrarSesion()
    {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header("Location: ../index.php");
    }
    function escapar($valor) 
    {
        return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
    }
}

?>
