<?php
include '../class/database.php';
$conexion = new Database();
$conexion->conectarDB(); 
session_start();
$idemp=$_SESSION["IDUSU"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../src/app.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Pendientes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>
<body>

  <style>
  </style>
    <!--header-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php" id="logo">Toy's Pizza</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="puntoventa.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cocina.php">Cocina</a>
          </li>
          <li>
            <a class="nav-link" href="pendientes.php">Pendientes</a>
          </li>
          <li>
            <h6 id="miTabla"></h6>
          </li>
          <li>
            <a class="nav-link" href="cierre.php">Cierre</a>
          </li>
          <li>
            <a class="nav-link" href="solicitar.php">Solicitar</a>
          </li>
          <li>
            <a class="nav-link" href="entrada.php">Entrada</a>
          </li>
          <li>
            <a class="nav-link" href="terminadas.php">Entregas</a>
          </li>
          <li>
            <a class="nav-link" href="disponibles.php">Disponibilidad</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="verperfilv1.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Perfil
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../scripts/cerrarSesion.php">Cerrar Sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
      <!--cuerpo-->
      <?php
        $tabla = $conexion->seleccionar("SELECT NOTIFICACIONES.ID_NOT, ORDEN_VENTA.NO_ORDEN, ORDEN_VENTA.TOTAL, USUARIOS.NOMBRE, USUARIOS.TELEFONO, USUARIOS.CORREO
        FROM NOTIFICACIONES
        Inner Join ORDEN_VENTA on ORDEN_VENTA.NO_ORDEN=NOTIFICACIONES.NUM_ORDEN
        Inner Join USUARIOS ON USUARIOS.ID_USUARIO = ORDEN_VENTA.USUARIO
        WHERE NOTIFICACIONES.ID_SUC=".$_SESSION['IDSUCUR']." AND NOTIFICACIONES.ESTADO='PENDIENTE' AND NOTIFICACIONES.FECHA=CURDATE() GROUP BY ORDEN_VENTA.NO_ORDEN");
        $CONSNUMNOT=$conexion->seleccionar("SELECT COUNT(ID_NOT) AS 'NOT' FROM NOTIFICACIONES WHERE ID_SUC=".$_SESSION['IDSUCUR']." AND ESTADO='PENDIENTE' AND NOTIFICACIONES.FECHA=CURDATE()");
        ///TABLA DONDE SE DESPLIEGAN LOS REGISTROS //////////////////////////////
        foreach($CONSNUMNOT as $x)
        {
        $CountNotifs= $x->NOT;
        }
        if($CountNotifs==0)
        {
            echo"<h1> No hay pedidos... </h1>";
        }
        else
        {
        foreach ($tabla as $registro)  
        {
        echo  "<div class='container'>
        <div class='rows d-flex justify-content-center'>";
        
        echo "<div class='col-lg-9 offset-lg-2'> <h2 >ORDEN #$registro->NO_ORDEN</h2>  </div>"; ?>   
        <?php
        $ORDEN=$registro->NO_ORDEN;
        $CORREO=$registro->CORREO;
        $NOTI=$registro->ID_NOT;
       echo "</div>";
        
        echo "</div>";
        echo "<table class = 'table table-hover'>
        <thead class = 'table-danger'>
        <tr>
        <th>PRODUCTO</th><th>TAMAÑO</th><th>CANTIDAD</th>
        </tr>
        </thead>";  
        $prods=$conexion->seleccionar("SELECT PRODUCTOS.NOMBRE, PRODUCTOS.TAMANO, DETALLE_ORDEN.CANTIDAD FROM ORDEN_VENTA INNER JOIN DETALLE_ORDEN on DETALLE_ORDEN.NO_ORDEN=ORDEN_VENTA.NO_ORDEN
        INNER JOIN PRODUCTOS on PRODUCTOS.CODIGO=DETALLE_ORDEN.PRODUCTO WHERE ORDEN_VENTA.NO_ORDEN =".$ORDEN."");
        foreach($prods as $reg)
        {
        echo "<tbody class='table-warning'>";
        echo "<tr>";
        echo "<td> $reg->NOMBRE </td>";
        echo "<td> $reg->TAMANO </td>";
        echo "<td> $reg->CANTIDAD </td>";
        echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<div class='col-lg-6 offset-lg-3'><h3> Datos del cliente </h3><table class = 'table table-hover'>
        <thead class = 'table-primary'>
        <tr>
        <th>Cliente</th><th>Numero</th><th>Total</th>
        </tr>
        </thead>
        <tbody class='table-warning'>";
          echo "<tr>";
          echo "<td> $registro->NOMBRE </td>";
          echo "<td> $registro->TELEFONO </td>";
          echo "<td> $".$registro->TOTAL." </td>";
          echo "</tr> </tbody> </table>
        </div>";
        echo"
        <div class= 'col-lg-6 offset-lg-4 d-inline-flex col-6 offset-3'>
        <row class='col-lg-6'>
        <form action='../scripts/aceptarp.php' method='post' class='col-6 col-lg-6'>
        <input type='hidden' name='correo' id='correo' value='".$CORREO."'>
        <input type='hidden' name='noorder' id='noorder' value='".$ORDEN."'>
        <input type='hidden' name='OV' id='OV' value='EN PROCESO'>
        <input type='hidden' name='noti' id='noti' value='".$NOTI."'>
        <button type='submit' class='btn btn-primary'>Aceptar pedido </button>
        </form>
        </row>
        <row class='col-lg-6'>
        <form action='../scripts/aceptarp.php' method='post' class='col-6 col-lg-6'>
        <input type='hidden' name='correo' id='correo' value='".$CORREO."'>
        <input type='hidden' name='noorder' id='noorder' value='".$ORDEN."'>
        <input type='hidden' name='noti' id='noti' value='".$NOTI."'>
        <input type='hidden' name='OV' id='OV' value='CANCELADA'>
        <button type='submit' class='btn btn-danger'>Rechazar pedido </button>
        </form>
        </row>
        </div>
        <hr>
        </div> ";
        }
     }
        ?>
</body>
</html>