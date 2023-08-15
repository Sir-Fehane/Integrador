<?php
session_start();
include '../class/database.php';
$conexion = new Database();
$conexion->conectarDB();
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
}
else
 {
  if ($_SESSION["rol"] == 2) {
    header("Location: ../index.php");
    exit;
  } elseif ($_SESSION["rol"] == 1) { 
    header("Location: admin.php");
    exit;
  }
 }

$cons="SELECT SUCURSALES.ID_SUC FROM SUCURSALES INNER JOIN EMPLEADO_SUCURSAL ON EMPLEADO_SUCURSAL.SUCURSAL=SUCURSALES.ID_SUC INNER JOIN USUARIOS ON USUARIOS.ID_USUARIO=EMPLEADO_SUCURSAL.EMPLEADO WHERE USUARIOS.ID_USUARIO=".$_SESSION["IDUSU"]."";
$resultadocons=$conexion->seleccionar($cons);
foreach($resultadocons as $abc)
{
  $_SESSION['IDSUCUR']=$abc->ID_SUC;

}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../src/app.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Cocina</title>
    <script type="text/javascript">

		function tiempoReal()
		{
			var tabla = $.ajax({
				url:'tablaConsulta.php',
				dataType:'text',
				async:false
			}).responseText;

			document.getElementById("miTabla").innerHTML = tabla;
		}
		setInterval(tiempoReal, 1000);
		</script>
</head>
<body>

  <style>
  </style>
    <!--header-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="puntoventa.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cocina.PHP">Cocina</a>
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
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="verperfilv1.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Perfil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../scripts/cerrarSesion.php">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <button class="btn btn-outline" id="btn-carrito" type="button" data-bs-toggle="offcanvas" data-bs-target="#carrito" aria-controls="offcanvasScrolling">Resumen de compra</button>
          </form>
        </div>
      </div>
    </nav>
      <!--cuerpo-->
      <?php      
      $sexo = 0;
        $ordenesact = "SELECT DE.NO_ORDEN from DETALLE_ORDEN DE inner join ORDEN_VENTA OV ON OV.NO_ORDEN = DE.NO_ORDEN where DATE(OV.HORA_FECHA) = CURDATE() 
        AND OV.ESTADO='EN PROCESO' group by DE.NO_ORDEN;";
        $tabla = $conexion->seleccionar($ordenesact);
        foreach ($tabla as $registro)  
        {
        echo "<div class='container'>
        <div class='rows d-flex justify-content-center'>";
        echo "<div class='col-lg-9'> <h2 >ORDEN $registro->NO_ORDEN</h2>  </div>" ?>   
<div class="col-lg-3">
    <form action="../views/cocina.PHP" method="post">
        <input type="hidden" name="no_orden" value="<?php echo $registro->NO_ORDEN; ?>">
        <button type="submit" class="col-auto btn btn-sm btn-success" name="editar_orden">Terminar</button>
        <button type="submit" class="col-auto btn btn-sm btn-danger" name="cancelar_orden">Cancelar</button>
    </form>
</div>
        <?php
       echo "</div>";?>
<?php

if (isset($_POST['editar_orden'])) {
    // Obtener el número de orden enviado desde el formulario
    $no_orden = $_POST['no_orden'];

    // Realizar el UPDATE en la base de datos para cambiar el estado de la orden
    try {
        $estado_nuevo = "TERMINADO"; // Reemplaza con el nuevo estado deseado
        $update_sql = "UPDATE ORDEN_VENTA SET ESTADO = :estado_nuevo WHERE NO_ORDEN = :no_orden";

        // Preparar la consulta
        $stmt = $conexion->getDB()->prepare($update_sql);

        // Asignar valores a los parámetros
        $stmt->bindParam(':estado_nuevo', $estado_nuevo);
        $stmt->bindParam(':no_orden', $no_orden);

        // Ejecutar la consulta
        $stmt->execute();


    } catch (PDOException $e) {
        // En caso de error, mostrar el mensaje de error
        echo "Error: " . $e->getMessage();
    }
    header("location: cocina.PHP");
}

if (isset($_POST['cancelar_orden'])) {
  // Obtener el número de orden enviado desde el formulario
  $no_orden = $_POST['no_orden'];

  // Realizar el UPDATE en la base de datos para cambiar el estado de la orden
  try {
      $estado_nuevo = "CANCELADA"; // Reemplaza con el nuevo estado deseado
      $update_sql = "UPDATE ORDEN_VENTA SET ESTADO = :estado_nuevo WHERE NO_ORDEN = :no_orden";

      // Preparar la consulta
      $stmt = $conexion->getDB()->prepare($update_sql);

      // Asignar valores a los parámetros
      $stmt->bindParam(':estado_nuevo', $estado_nuevo);
      $stmt->bindParam(':no_orden', $no_orden);

      // Ejecutar la consulta
      $stmt->execute();


  } catch (PDOException $e) {
      // En caso de error, mostrar el mensaje de error
      echo "Error: " . $e->getMessage();
  }
   header("location: cocina.PHP");
}

        ?>
<input type="hidden">
        </form>
        <?php
        echo "<div class ='table-responsive'>";
        echo "<table class = 'table table-hover'>
        <thead class = 'table-dark'>
        <tr>
        <th>PRODUCTO</th><th>TAMAÑO</th><th>CANTIDAD</th><th>NOTAS</th><th>ESTADO</th>
        </tr>
        </thead>";
        $pizzas = " SELECT DE.NO_ORDEN , P.NOMBRE ,P.TAMANO, DE.CANTIDAD AS CANTIDAD_PIZZAS, DE.NOTAS,  OV.ESTADO 
        FROM DETALLE_ORDEN DE 
        INNER JOIN ORDEN_VENTA OV ON OV.NO_ORDEN = DE.NO_ORDEN 
        INNER JOIN PRODUCTOS P ON DE.PRODUCTO = P.CODIGO 
        WHERE DE.NO_ORDEN=$registro->NO_ORDEN;";
        $tabla2 = $conexion->seleccionar($pizzas);
        foreach($tabla2 as $registro2){ 
       echo "<tbody>";
          echo "<tr>";
          echo "<td> $registro2->NOMBRE </td>";
          echo "<td> $registro2->TAMANO </td>";
          echo "<td> $registro2->CANTIDAD_PIZZAS </td>";
          echo "<td> $registro2->NOTAS </td>";
          echo "<td> $registro2->ESTADO </td>";
          echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        }
        ?>
</body>
</html>