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
$ordenesact = "SELECT DE.NO_ORDEN FROM DETALLE_ORDEN DE INNER JOIN ORDEN_VENTA OV ON OV.NO_ORDEN = DE.NO_ORDEN WHERE DATE(OV.HORA_FECHA) = CURDATE() AND OV.ESTADO='EN PROCESO' GROUP BY DE.NO_ORDEN;";
$tabla = $conexion->seleccionar($ordenesact);

echo "<div class='container'>
        <div class='table-responsive'>";

if (count($tabla) > 0) {
    foreach ($tabla as $registro) {
        echo "<div class='col-lg-9'>
                  <h2>ORDEN $registro->NO_ORDEN</h2>
              </div>
              <div class='table-responsive'>
                  <form action='../views/cocina.PHP' method='post'>
                      <input type='hidden' name='no_orden' value='$registro->NO_ORDEN'>
                      <button type='submit' class='btn btn-sm btn-success' name='editar_orden'>Terminar</button>
                      <button type='submit' class='btn btn-sm btn-danger' name='cancelar_orden'>Cancelar</button>
                  </form>
              </div>
              <hr>";
        echo "<div class='col-lg-12'>
                  <div class='table-responsive-md' style='overflow-x: auto;'>
                      <table class='table table-hover table-striped'>
                          <thead class='table-dark'>
                              <tr>
                                  <th>PRODUCTO</th><th>TAMAÑO</th><th>CANTIDAD</th><th>NOTAS</th><th>ESTADO</th>
                              </tr>
                          </thead>
                          <tbody>";

        $pizzas = "SELECT DE.NO_ORDEN, P.NOMBRE, P.TAMANO, DE.CANTIDAD AS CANTIDAD_PIZZAS, DE.NOTAS, OV.ESTADO 
                   FROM DETALLE_ORDEN DE 
                   INNER JOIN ORDEN_VENTA OV ON OV.NO_ORDEN = DE.NO_ORDEN 
                   INNER JOIN PRODUCTOS P ON DE.PRODUCTO = P.CODIGO 
                   WHERE DE.NO_ORDEN = $registro->NO_ORDEN;";

        $tabla2 = $conexion->seleccionar($pizzas);

        foreach ($tabla2 as $registro2) { 
            echo "<tr>";
            echo "<td> $registro2->NOMBRE </td>";
            echo "<td> $registro2->TAMANO </td>";
            echo "<td> $registro2->CANTIDAD_PIZZAS </td>";
            echo "<td> $registro2->NOTAS </td>";
            echo "<td> $registro2->ESTADO </td>";
            echo "</tr>";
        }

        echo "</tbody></table></div></div>";
    }
} else 
{
    echo "<br>";
    echo "<h3 align='center'>Por el momento no hay órdenes...</h3>";
}

echo "</div></div>";

if (isset($_POST['editar_orden'])) {
    $no_orden = $_POST['no_orden'];
    $asd=$conexion->seleccionar("SELECT USUARIOS.CORREO FROM USUARIOS INNER JOIN ORDEN_VENTA ON ORDEN_VENTA.NO_ORDEN WHERE ORDEN_VENTA.NO_ORDEN=".$no_orden."");
    foreach($asd as $cry)
    {
      $_SESSION['CORREO'] = $cry->CORREO;
    }
    try {
        $estado_nuevo = "ENTREGADO";
        $update_sql = "UPDATE ORDEN_VENTA SET ESTADO = :estado_nuevo WHERE NO_ORDEN = :no_orden";

        $stmt = $conexion->getDB()->prepare($update_sql);
        $stmt->bindParam(':estado_nuevo', $estado_nuevo);
        $stmt->bindParam(':no_orden', $no_orden);
        $stmt->execute();
        include "../Mail/CORREOCOCINATERMINADO.php";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    echo "<script>window.location.href = 'cocina.PHP';</script>";
}

if (isset($_POST['cancelar_orden'])) {
    $no_orden = $_POST['no_orden'];

    try {
      $asd=$conexion->seleccionar("SELECT USUARIOS.CORREO FROM USUARIOS INNER JOIN ORDEN_VENTA ON ORDEN_VENTA.NO_ORDEN WHERE ORDEN_VENTA.NO_ORDEN=".$no_orden."");
    foreach($asd as $cry)
    {
      $dfg= $cry->CORREO;
      $_SESSION['CORREO'] = $dfg;
    }
        $estado_nuevo = "CANCELADA";
        $update_sql = "UPDATE ORDEN_VENTA SET ESTADO = :estado_nuevo WHERE NO_ORDEN = :no_orden";

        $stmt = $conexion->getDB()->prepare($update_sql);
        $stmt->bindParam(':estado_nuevo', $estado_nuevo);
        $stmt->bindParam(':no_orden', $no_orden);
        $stmt->execute();
        include "";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    header("location: cocina.PHP");
}
?>
</body>
</html>