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
        $ordenesact = "SELECT DE.NO_ORDEN from DETALLE_ORDEN DE  group by DE.NO_ORDEN;";
        $tabla = $conexion->seleccionar($ordenesact);
        foreach ($tabla as $registro)
        {
        echo "<div class='container'>";
        echo "<h1 align='Center'>ORDEN $registro->NO_ORDEN</h1>";
        echo "<table class = 'table table-hover'>
        <thead class = 'table-dark'>
        <tr>
        <th>PRODUCTO</th><th>TAMAÑO</th><th>CATIDAD</th><th>NOTAS</th>
        </tr>
        </thead>";
        $pizzas = " SELECT DE.NO_ORDEN , P.NOMBRE ,P.TAMAÑO, DE.CANTIDAD AS CANTIDAD_PIZZAS, DE.NOTAS   from DETALLE_ORDEN DE INNER JOIN PRODUCTOS P ON DE.ID_DETALLE = P.CODIGO WHERE DE.NO_ORDEN=$registro->NO_ORDEN group by DE.NO_ORDEN, P.TAMAÑO;";
        $tabla2 = $conexion->seleccionar($pizzas);
        foreach($tabla2 as $registro2){ 
       echo "<tbody>";
          echo "<tr>";
          echo "<td> $registro2->NOMBRE </td>";
          echo "<td> $registro2->TAMAÑO </td>";
          echo "<td> $registro2->CANTIDAD_PIZZAS </td>";
          echo "<td> $registro2->NOTAS </td>";
          echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        }
        ?>
</body>
</html>