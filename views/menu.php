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
          <a class="nav-link active" aria-current="page" href="menu.php">Promociones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="menu-pizza.php">Menu</a>
        </li>
      </ul>
      <!--Menu-->
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-lg-4">
            <div class="container ">
              <img src="../img/promo.jpg" id="promopizza">
            </div>
          </div>
          <div class="col-12 col-lg-3 offset-0 offset-lg-1">
              <div class="container mt-5">
                <img src="../img/recrefre.jpg" class="rectangulos">
              </div>
              <div class="container mt-5">
                <img src="../img/recrefre.jpg" class="rectangulos">
              </div>
          </div>
          <div class="col-12 col-lg-4 mt-5 mt-lg-0">
            <div id="carouselExample" class="carousel slide">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="../img/migueljpg.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="../img/yona.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="../img/mexi.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        
            <div class="container col-12 col-lg-8 comida" id="ero">
            <a href="menu-pizzas.html" class="disp"> 
                <img src="../img/cajap.png" width="10%">
                ¿Listo para ordenar?
              </a>
              </div>
        </div>
      
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