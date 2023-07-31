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
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg he">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="../index.php">
                <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
                Toy's Pizza
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active navtext" aria-current="page" href="#">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navtext" href="menu.php">Menu</a>
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
                  <li>
                    <div>
                    <input type="radio" id="huey" name="drone" value="huey"
                           checked>
                    <label for="huey">Sol de Ote</label>
                  </div>
                </li>
                  <li>
                  <div>
                    <input type="radio" id="dewey" name="drone" value="dewey">
                    <label for="dewey">Triana</label>
                  </div>
                 </li>
                <li>
                  <div>
                    <input type="radio" id="louie" name="drone" value="louie">
                    <label for="louie">Pedregal</label>
                  </div>
                </li>
                </ul>
            </ul>
              <li class="nav-item navtext">
                <div class="container">
                  <div class="d-flex justify-content">
                  <button type="button" class="btn btn-danger jus" data-bs-toggle="modal" data-bs-target="#login">Iniciar Sesion</button>
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#register">Registrate</button>
                  </div>
              </div>
              </li>
          </div>
        </div>
      </nav>
      <!--SUB Barra navegacion-->
      <ul class="nav nav-tabs justify-content-center nav-fill">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="menu.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Productos</a>
        </li>

      </ul>
      <!--Cards reversibles-->
      <section>
        <div class="container d-inline-flex">
          <div class="row">
            <form method="post" id="form" name="form" action="../scripts/carrito.php">
            <?php 
            include '../class/database.php';
            $db = new Database();
            $db->conectarDB();
            $cons="SELECT * FROM PRODUCTOS GROUP BY NOMBRE";
            $res=$db->seleccionar($cons);
            foreach($res as $registro)
            {
            echo" <div class='carta col-12 col-lg-4'>
            <div class='face front'>
            <img src=''>
            <h3>$registro->NOMBRE</h3>
            </div>
            <div class='face back'>
            <h3>$registro->NOMBRE</h3>
            <input id='nombre' type='hidden' value='$registro->NOMBRE'/>
            <p>$registro->DESCRIPCION</p>
            
            <div class='linka d-flex mb-lg-3'>
            <button type='submit' class='btn butn-menu'>";
            echo"<i class='bx bxs-cart'>Agregar al carrito</i>
            </button>
            </div>";
            $tamaño="SELECT TAMAÑO FROM PRODUCTOS WHERE NOMBRE='$registro->NOMBRE' GROUP BY TAMAÑO";
            $TamañoCons=$db->seleccionar($tamaño);
            echo"<select name='Tamaño' class='Tama'>";
            foreach($TamañoCons as $Tam)
            {
            echo"<option value='".$Tam->TAMAÑO."'>".$Tam->TAMAÑO."</option>";
            }
           
            echo"</select>
            </div>
            </div>";
          }
            $db->desconectarDB();
            ?>
            </form>
            
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
</body>
</html>