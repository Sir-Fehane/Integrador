<?php
// include database configuration file
session_start();
include'../class/database.php';
$dbase= new Database();
$dbase->conectarDB();
include '../carrito/dbConfig.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Toys Pizza</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/boot.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="../img/pizza.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau+Office:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg he">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#">
                <img src="img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
                Toy's Pizza
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active navtext" aria-current="page" href="../index.php">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navtext" href="views/menu-pizza.php">Menu</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle navtext" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Sobre nosotros
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item drup" href="#">Contacto</a></li>
                  <li><a class="dropdown-item drup" href="#">Servicio</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item drup" href="#">Informacion</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle navtext" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Selecciona tu sucursal
                </a>
                <ul class="dropdown-menu">
                  
                </ul>
              </li>
                </ul>
                
              <li class="nav-item navtext">
                <div class="container">
                  <div class="d-flex justify-content">
                  <?php
                    if(isset($_SESSION["usuario"]))
                    {
                      $usuario1 = $_SESSION['usuario'];
                      $consulta1 = "SELECT U.ID_USUARIO AS ID, U.NOMBRE AS 'NOMBRE', U.DIRECCION AS 'DIRECCION', U.TELEFONO AS 'TELEFONO', U.CORREO AS 'CORREO',
                      U.img_chidas FROM USUARIOS U
                      WHERE NOMBRE = '$usuario1'";
                      $tabla = $dbase->seleccionar($consulta1);
                      foreach ($tabla as $registro)
                      {
                        $imgchida = $registro->img_chidas;
                     echo "<img src='$imgchida' style='border-radius: 10px;' alt='img'width= '50px'
                     height=' 50px'>";
                      }
                      echo "<li class='nav-item dropdown'>
                      <a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                      " . $_SESSION["usuario"] . "</a>
                      <ul class='dropdown-menu'>
                      <li><a class='dropdown-item text-black' href='views/verperfilv.php'>Ver perfil</a></li>
                      <li><a class='dropdown-item text-black' href='scripts/cerrarSesion.php'>Cerrar sesión</a></li>
                      </ul>
                      </li>";
                    }
                    else
                    {
                    ?>
                  <button type="button" class="btn btn-danger jus" data-bs-toggle="modal" data-bs-target="#login">Iniciar Sesion</button>
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#register">Registrate</button>
                  <?php
                    }
                  ?>
                  </div>
              </div>
              </li>
          </div>
        </div>
      </nav>
      <!--SUB Barra navegacion-->
      <ul class="nav nav-tabs justify-content-center nav-fill">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="menu.php">Promociones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Menu</a>
        </li>
      </ul>
      <section>
      <div class="container">
    <div id="products" class="row">
        <?php
        //get rows query
        $query = $db->query("SELECT * FROM PRODUCTOS ORDER BY CODIGO ");
        if($query->num_rows > 0){ 
            while($row = $query->fetch_assoc()){
        ?>
            <div class="carta col-12 col-lg-4">
            <div class="face front">
            <img src="../img/pepe.jpg">
            <h3><?php echo $row["NOMBRE"]; ?></h3>
            <input name='titulo' type='hidden' id='titulo' value>
            </div>
            <div class='face back'>
            <h3><?php echo $row["NOMBRE"]; ?></h3>
            <p><?php echo $row["DESCRIPCION"]; ?></p>
            <p><?php echo $row["TAMAÑO"];?></p>
            <div class='linka d-flex mb-lg-3'>
            <div class="row">
                        <div class="col-md-6">
                            <p class="lead"><?php echo '$'.$row["PRECIO"].' MX'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn butn-menu" href="../carrito/cartAction.php?action=addToCart&id=<?php echo $row["CODIGO"]; ?>">Agregar al carrito</a>
                        </div>
                    </div>
            </div>
            </div>
            </div>
        <?php } }else{ ?>
        <p>No hay productos...</p>
        <?php } ?>
    </div>
</div>
</section>
<!--Footer-->
<section >
        <div class="footer">
            <div class="main position-relative">
                <div class="colu col-6 col-lg-4">
                    <h4>Links<br>del Menu</h4>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Servicio</a></li>
                    </ul>
                </div>
                <div class="colu col-6  col-lg-4">
                    <h4>Nuestro<br>Servicio</h4>
                    <ul>
                        <li><a href="#">Web</a></li>
                        <li><a href="#">Desarrollo</a></li>
                        <li><a href="#">Marketing</a></li>
                        
                    </ul>
                </div>
                <div class="colu col-6 col-lg-4 offset-3 offset-lg-0">
                    <h4><br>Informacion</h4>
                    <ul>
                        <li><a href="#">Sobre nosotros</a></li>
                        <li><a href="#">Envios</a></li>
                        <li><a href="#">T&C</a></li>
                       
                    </ul>
                    <div class="social">
                      <a href="https://www.facebook.com/pizzastoystorreon"><i class='bx bxl-facebook' ></i></a>
                      <a href="#" style="margin-left: 5%;"><i class='bx bx-phone'></i></a>
                      </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Modal login-->
<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Iniciar sesion</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="../scripts/login.php" method="post">
                <label for="Nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="usuario" required>
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
                <div>
                  <a href="">Olvide mi contraseña</a>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-danger">Iniciar sesion</button>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal register-->
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Registro</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="../scripts/registrarse.php" method="POST">
                <label for="Nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
                <label for="direccion" class="form-label">Direccion</label>
                <input type="text" class="form-control" required name="direccion">
                <label for="celular" class="form-label">Telefono</label>
                <input type="tel" name="telefono" class="form-control" required>
                <label for="email" class="form-label">Correo</label>
                <input type="email" name="correo" placeholder="Opcional" class="form-control">
                <div class="modal-footer">
                  <button type="submit" class="btn btn-warning">Registrar</button>
                </div>
              </form>
</body>
</html>