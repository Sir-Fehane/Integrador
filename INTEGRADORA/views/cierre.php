<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/estilo.css" />
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <script src="./src/app.js"></script>
  </head>
  <body>
    <!--Header/navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./punto-de-venta.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./cocina.php">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="./cierre.php">Cierre</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Perfil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="#">Something else here</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--Contenido-->
    <div class="container" #id="cuerpo">
      <h2 align="center">Cierre</h2>
      <hr>
      <div class="justify-content-center" id="contenedor">
        <div class="table-responsive">
          <table class="table align-middle table-sm">
            <form action="" method="post">
            <thead>
            </thead>
            <tbody>
              <?php
                include '../class/database.php';
                $conexion = new database();
                $conexion->conectarDB();
                $consulta ="SELECT INVENTARIO.NOMBRE as N FROM INVENTARIO";
                $reg = $conexion->seleccionar($consulta);
              foreach($reg as $value){
                echo"
                <tr>
                  <th scope='row'><label class='control-label' for='$value->N'>$value->N</label></th>
                  <td colspan='2' class='table-active'><input type='text' name='$value->N' class='form-control' required></td>
                </tr>                
                ";
              }              
              ?>             
            </tbody>
          </form>
          </table>
        </div>
        <br>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
          </div>  
        </form>
      </div>    
    <script src="./js/bootstrap.bundle.js"></script>
  </body>
</html>
