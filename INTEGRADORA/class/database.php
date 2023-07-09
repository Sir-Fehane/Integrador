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

    function registrarUsuario($consulta)
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
    function loginUsuario($consulta)
    {
        try
        {
            $stmt = $this->PDOAws->prepare($consulta);
            $stmt->execute();

            $rowCount = $stmt->rowCount();

            return ($rowCount > 0);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
}

?>