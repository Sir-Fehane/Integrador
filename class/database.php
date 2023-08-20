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
            $options=array(
                PDO::ATTR_EMULATE_PREPARES=>false,
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
              );
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
    function selec($consulta)
    {
        try
        {
            $resultado = $this->PDOAws->query($consulta);
            $fila = $resultado->fetchAll(PDO::FETCH_ASSOC);
            return $fila;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function selecsinall($consulta)
    {
        try
        {
            $resultado = $this->PDOAws->query($consulta);
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
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
    function verifica($correo, $contra)
    {
        try
        {
            $pase = false;
            $query = "SELECT * FROM USUARIOS WHERE CORREO = '$correo'";
            $consulta = $this->PDOAws->query($query);
            while($renglon = $consulta->fetch(PDO::FETCH_ASSOC))
            {
                if (password_verify($contra, $renglon['CONTRASENA'])) 
                {
                    $nombre = $renglon['NOMBRE'];
                    $pase = true;
                    $rol = $renglon['ROL'];
                    $id_usuar=$renglon['ID_USUARIO'];
                }
            }
            if($pase)
            {
                $_SESSION["correo"] = $correo;
                $_SESSION["usuario"] = $nombre;
                $_SESSION["rol"] = $rol;
                $_SESSION["IDUSU"]= $id_usuar;
                //echo "<div class = 'alert alert-success'>";
                //echo "<h2 align = 'center'>Bienvenido ".$_SESSION["usuario"]."</h2> </div>";
                //echo "</div>";
                return true;
            }
            else
            {
                //echo "<div class = 'alert alert-danger'>";
                //echo "<h2 align = 'center'>Usuario o password incorrecto</h2>";
                //echo "</div>";
                return false;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
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
    public function getDB()
    {
        if ($this->PDOAws === null) {
            $this->conectarDB();
        }
        return $this->PDOAws;
    }
    function prepararConsulta($query) {
        return $this->PDOAws->prepare($query);
    }
    function execute($query, $params = array()) {
        try {
            $consulta_preparada = $this->PDOAws->prepare($query);
            
            foreach ($params as $param => $value) {
                $consulta_preparada->bindValue($param, $value);
            }
            
            $resultado = $consulta_preparada->execute();
            
            return $resultado;
        } catch (PDOException $e) {
            // Manejar errores si es necesario
            return false;
        }
    }
}


?>
