<?php
session_start();
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
    <title>Cocina</title>
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
                <a class="nav-link active" aria-current="page" href="#">Inicio</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Perfil
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
            </ul>
            <!--perfil-->

          </div>
        </div>
      </nav>
      <!--cuerpo-->
      <?php      
      $sexo = 0;
      
        include '../class/database.php';
        $conexion = new Database();
        $conexion->conectarDB();
        $ordenesact = "SELECT DE.NO_ORDEN from DETALLE_ORDEN DE inner join ORDEN_VENTA OV ON OV.NO_ORDEN = DE.NO_ORDEN where DATE(OV.HORA_FECHA) = CURDATE()  AND DE.ESTADO='EN PROCESO' group by DE.NO_ORDEN;";
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
// ... (código anterior) ...

if (isset($_POST['editar_orden'])) {
    // Obtener el número de orden enviado desde el formulario
    $no_orden = $_POST['no_orden'];

    // Realizar el UPDATE en la base de datos para cambiar el estado de la orden
    try {
        $estado_nuevo = "ENTREGADA"; // Reemplaza con el nuevo estado deseado
        $update_sql = "UPDATE DETALLE_ORDEN SET ESTADO = :estado_nuevo WHERE NO_ORDEN = :no_orden";

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
      $update_sql = "UPDATE DETALLE_ORDEN SET ESTADO = :estado_nuevo WHERE NO_ORDEN = :no_orden";

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
        echo "</div>";
        echo "<table class = 'table table-hover'>
        <thead class = 'table-dark'>
        <tr>
        <th>PRODUCTO</th><th>TAMAÑO</th><th>CATIDAD</th><th>NOTAS</th><th>ESTADO</th>
        </tr>
        </thead>";
        $pizzas = " SELECT DE.NO_ORDEN , P.NOMBRE ,P.TAMAÑO, DE.CANTIDAD AS CANTIDAD_PIZZAS, DE.NOTAS,  DE.ESTADO from DETALLE_ORDEN DE INNER JOIN PRODUCTOS P ON DE.ID_DETALLE = P.CODIGO WHERE DE.NO_ORDEN=$registro->NO_ORDEN group by DE.NO_ORDEN, P.TAMAÑO;";
        $tabla2 = $conexion->seleccionar($pizzas);
        foreach($tabla2 as $registro2){ 
       echo "<tbody>";
          echo "<tr>";
          echo "<td> $registro2->NOMBRE </td>";
          echo "<td> $registro2->TAMAÑO </td>";
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