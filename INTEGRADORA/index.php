<!DOCTYPE html>
<html lang="en">
<head>
<title>Toys Pizza</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/boot.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="img/pizza.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ysabeau+Office:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body> 

<nav class="navbar navbar-expand-lg he">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#">
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
                <a class="nav-link navtext" href="#">Menu</a>
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
    <!--Cuerpo-->
    <section class="h" id="h">
      <div class="container d-inline">
        <div class="row">
        <div class="h-t col-lg-6">
          
            <h1>Bienvenido a Toy's Pizza</h1>
            <h2>La primera y original pizzeria de <br> La Laguna <3 </h2>
            <a href="#" class="butn">Checa nuestro menú</a>
        </div>
        
        <div class="h-img col-lg-5 containe">
            <img src="img/piejm.png">
        </div>
      </div>
     </div>
    </section>
    <!---->
    <section class="abt" id="abt">
        <div class="abt-img">
            <img src="img/logotp.jpg">
        </div>
        <div>
            <span>Sobre nosotros</span>
            <h2>Somos una pizzeria <br> familiar!</h2>
            <p>Nos centramos en la calidad y el precio para tu bolsillo, todos nuestros productos están hechos con amor y sobre todo, calidad.</p>
            <a href="#" class="butn">Contactanos!</a>
        </div>
    </section>
    <!--Pizzas-->
    <section>
      <div class="heading">
        <span>Prueba nuestras Pizzas</span>
        <h2>Tenemos una gran variedad de sabores y tamaños para toda ocasión.</h2>
    </div>
      <div class="container" id="contenedor">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card" style="width: 17rem;">
                    <img src="img/pepe.jpg" class="card-img-top carts" alt="...">
                    <div class="card-body estcart">
                        <h2>Pizza Peperoni</h2>
                      <p class="card-text">Pizza de Peperoni, queso y salsa de pizza</p>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-40" style="width: 17rem;">
                    <img src="img/mexi.jpg" class="card-img-top carts" alt="...">
                    <div class="card-body estcart">
                        <h2>Pizza Mexicana</h2>
                      <p class="card-text">Pizza de carne molida, chile, tomate, cebolla, tocino</p>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-40" style="width: 17rem;">
                    <img src="img/cfrias.jpg" class="card-img-top carts" alt="...">
                    <div class="card-body estcart">
                        <h2>Pizza C. Frias</h2>
                      <p class="card-text">Pizza de Jamon / Chorizo / Peperoni. (solo 2 a elegir)</p>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-40" style="width: 17rem;">
                    <img src="img/hawa.jpg" class="card-img-top carts" alt="..." >
                    <div class="card-body estcart">
                        <h2>Pizza Hawaiiana</h2>
                      <p class="card-text">Pizza de Jamon, queso y piña<br><br></p>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-40" style="width: 17rem;">
                    <img src="img/espe.jpg" class="card-img-top carts" alt="...">
                    <div class="card-body estcart">
                        <h2>Pizza Especial</h2>
                      <p class="card-text">Pizza de jamon, Chorizo, peperoni, champiñones</p>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card" style="width: 17rem;">
                  <img src="img/mollete.jpg" class="card-img-top carts" alt="...">
                  <div class="card-body estcart">
                      <h2>Pizza Mollete</h2>
                    <p class="card-text">Pizza base de frijoles, con queso, chorizo y tocino</p>
                  </div>
                </div>
          </div>
        </div>
    </div>    
    </section>
    <!--Servicios-->
    <section class="servicios" id="servicios">
      <div class="heading">
          <span>Servicios</span>
          <h2>Comida de calidad</h2>
      </div>
      <div class="container d-inline">
        
        <div class="row">
      <div class="service-container col-12 col-lg-4 ">
          <div class="s-box">
              <img src="img/enpi.png">
              <h3>Orden</h3>
              <p>Simplificamos el proceso de pedido para que puedas personalizar tu pizza y realizarlo rápidamente.</p>
          </div>
      </div>
      <div class="service-container col-12 col-lg-4">
          <div class="s-box">
                  <img src="img/orpi.png">
                  <h3>Envio</h3>
                  <p>Nos comprometemos a entregar tu pizza en el menor tiempo posible, manteniéndote informado en caso de demoras.</p>
          </div>
      </div>
      <div class="service-container col-12 col-lg-4">
                  <div class="s-box">
                      <img src="img/repi.png">
                      <h3>Recibido</h3>
                      <p>En Toy's Pizza, nos esforzamos por superar tus expectativas y convertirnos en tu pizzería de confianza. ¡Gracias por elegirnos y permitirnos servirte con pasión!</p>
                  </div>
      </div>
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
            <form action="views/login.php" method="post">
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
            <form action="views/registrarse.php" method="POST">
                <label for="Nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
                <label for="confpass" class="form-label">Confirmar contraseña</label>
                <input type="confpass" name="password" class="form-control" required>
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
        </div>
      </div>
    </div>
  </div>
</body>
</html>