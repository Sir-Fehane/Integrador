<?php 
session_start();
if(!isset($_SESSION['rol']))
{

}
else
 {
  if ($_SESSION["rol"] == 1) {
    header("Location: ../admin.php");
    exit;
  }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/boot.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Toys Pizza</title>
</head>
<body>
<nav class="navbar navbar-expand-lg he" id="nav">
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
                <a class="nav-link active navtext" aria-current="page" href="#">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navtext" href="views/menu-pizza.php">Menu</a>
              </li>
              <?php
    if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3) {
        echo '<li class="nav-item">
                  <a class="nav-link navtext" href="views/puntoventa.php">Punto de Venta</a>
              </li>';
    }
    ?>
                </ul>
                <li class="nav-item">
            <a href="carrito/viewCart.php" title="Ver carrito"  id="carro"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAA/5JREFUWEedWE2IFEcYfV/PrhA96kHQgxhCdqpbBIWAJHjwIDkkxO3NHhZPejAK4j2QgJAcchMMEdaDGxAWyWZ6kmMCEQQDguLB2a5ZQSIeFMGbIBF1+pPq7p2p6q7qqd6+7Ex3/bzvfe+9rlnCli8CwK1mT2aYc/Vv6rPlIhAY3H7PfC37NNdiFXBVdK1B5Av4Id8aQ+Usny18sNTWmbK+0TIRpxfHfDP/T4SbaRLd9W5BYxW6DMzPuhargCwq5RWZRKdbqddjsItd0osScWq1Tca0tNEXN6yC9emb1TZ26RUMlajylpVXRnQ4YP6i/Pqv7IefKfHm7mvw0njvrQJ1tV0sprsxwlMAgRqTMR0Y9sX6BIsZDbqDJqB1anxsUnBjFqV9F3H6G8CLahgT/TLsifPTAblyyNzJDroCqAqtuyCPEvOtvDbGSxAuufQ6qV81lCyoyvvaAkz06m0w++ujtY9ebN5uZEgNEnGq2hQWE+qLOg1VVqHXXANdTL4rk/ATE5ArvQB0F+Q5Yr6iTzCs6Ao6n4AtQD+RSbTPypCt2sNf3tv+evaDFwxsd7LhfH+ZM6yyZvwk++G3xUhllOJv3g2XU0Wc/gwgF7SfV2xr2ts96nT2P1ybe+zNkBoYnRh8mAXBI7Neywa6bvyQ35FJeEQfqom6mSaxkP4DxjHTvO60LQ4ALhNw3hwGzsokXNbdbbTMrpECaDQ/iDMKek06anac/jQH+npmx7tdD64ffFUt0i0MncuLHIgHUiX37tYRUEOqGMKNNImWqrr0ZkhN7MbyOwL/0MyST1YxiPB52ov+qq5lBGPjRgTMnRju7FD2nIEZW2X+J2x+NkzCvQyqTTGOH7UIsNzozstVIq5RXSumyWVG9piKcQKaYDFNGcaDTxl020Z1nSH7e62aPXVRl3dcwajbUjlOzKcpCMLe4qlWvyOT6IjX2356lhXpIeL1JQatNo6vph0X2QPgZJpEq9Vz9Ca7Rct8XoQVXkMFiunjVhFAPJBJ1Gv6fenhslqpeoMtXZvOc9WhTg3ZnWKnT8TpMginMMJ/wUxwYf337t82TUVfD49no+wyAuwHY0Um4TfegPxqgxL1KRCujQEwHg774dxYB+Nf/QQxv74BQtladTjHaflHuOKKCY+W1euuJTbxW9mLttnOL2IhfQPG7CYrGdH3w574sdomvZjmN4Hl6dzi8EAwGt0HKE9sAFc3WzFuR0l32dozhZD5XdbpHNpYEwPXf04Mhqbn0ASdAoURfxUwP5V9Swu0QlSLmWgPd+jPjbXuYPzIopFWL1c3lT7qc/+ez9fVvGPdp7aFD33eeWauXs3C1hqqH6zdG7jE69q0pctcIdm+JhfQ93JBvTYjB6UlAAAAAElFTkSuQmCC"/> </a>
            </li>
              <li class="nav-item navtext">
                <div class="container">
                  <div class="d-flex justify-content">
                  <?php
                  include 'class/database.php';
                  $db = new Database();
                  $db->conectarDB();
                    if(isset($_SESSION["usuario"]))
                    {
                      $usuario1 = $_SESSION['correo'];
                      $consulta1 = "SELECT U.ID_USUARIO AS ID, U.NOMBRE AS 'NOMBRE', U.DIRECCION AS 'DIRECCION', U.TELEFONO AS 'TELEFONO', U.CORREO AS 'CORREO',
                      U.ESTADO, U.img_chidas FROM USUARIOS U
                      WHERE CORREO = '$usuario1'";
                      $tabla = $db->seleccionar($consulta1);
                      foreach ($tabla as $registro)
                      {
                        $estado=$registro->ESTADO;
                        $imgchida = $registro->img_chidas;
                     echo "<img src='$imgchida' style='border-radius: 10px;' alt='img'width= '50px'
                     height=' 50px'>";
                      }
                      if ($registro->ESTADO == 'ACTIVADO') 
                      {
                        echo "<li class='nav-item dropdown'>
                                  <a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                  " . $_SESSION["usuario"] . "</a>
                                  <ul class='dropdown-menu'>
                                  <li><a class='dropdown-item text-black' href='views/verperfilv1.php'>Ver perfil</a></li>
                                  <li><a class='dropdown-item text-black' href='scripts/cerrarSesion.php'>Cerrar sesión</a></li>
                                  </ul>
                                  </li>";
                    } elseif ($registro->ESTADO == 'INACTIVO') {
                        header("Location: scripts/verificar_codigo.php");
                        exit;
                    }
                    }
                    else
                    {
                    ?>
                  <button type="button" class="btn btn-warning jus" data-bs-toggle="modal" data-bs-target="#login">Iniciar Sesion</button>
                  
                  <?php
                    }
                  ?>
                  </div>
              </div>
              </li>
          </div>
        </div>
      </nav>
    <!--Cuerpo-->
    <section class="h" id="h" style="background-image: url('https://toys-pizza.s3.amazonaws.com/imagenes/fondo.jpg'); background-size: cover; background-position: center; ">
  <div class="container d-flex align-items-center justify-content-center" id="cont">
    <div class="row">
      <div class="h-t d-flex align-items-center justify-content-center mt-3" style="margin:auto; text-align: center;">
        <h1 style="font-family: 'Anton', sans-serif; ">BIENVENIDO A TOY'S PIZZA</h1>
      </div>
      <div class="h-t col-lg-12 d-flex align-items-center justify-content-center mt-3">
        <a href="views/menu-pizza.php" class="butn">Checa nuestro menú</a>
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
            <span>Sobre nosotros:</span>
            <h2>Somos una pizzeria <br> familiar!</h2>
            <p>Nos centramos en la calidad y el precio para tu bolsillo; todos nuestros productos están hechos con amor y, sobre todo, calidad.</p>
            <a href="#fot" class="butn">Contactanos!</a>
        </div>
    </section>
    <!--Pizzas-->
    <section>
      <div class="heading">
        <span>Prueba nuestras Pizzas</span>
        <h2>Tenemos una gran variedad de sabores y tamaños para toda ocasión.</h2>
    </div>
    <div id="carousel" class="carousel slide" data-bs-ride="true" data-bs-interval="3500">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
    <button type="button" data-bs-target="#carousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/pepe.jpg" class="d-block w-100" alt="Pizza Pepperoni">
      <div class="carousel-caption d-none d-md-block">
        <h5>Pizza Pepperoni</h5>
        <p>La clasica pizza de pepperoni, con queso y salsa de pizza.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/mexi.jpg" class="d-block w-100" alt="Pizza Mexicana">
      <div class="carousel-caption d-none d-md-block">
        <h5>Pizza mexicana</h5>
        <p>Pizza de carne molida, chile, tomate, cebolla, tocino.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/cfrias.jpg" class="d-block w-100" alt="Pizza Carnes Frias">
      <div class="carousel-caption d-none d-md-block">
        <h5>Pizza de carnes frias</h5>
        <p>Pizza con opcion a elegir 2 ingredientes entre jamon, chorizo, pepperoni.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/hawa.jpg" class="d-block w-100" alt="Pizza Hawaiana">
      <div class="carousel-caption d-none d-md-block">
        <h5>Pizza hawaiana</h5>
        <p>Pizza de jamon, queso y piña.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/espe.jpg" class="d-block w-100" alt="Pizza Especial">
      <div class="carousel-caption d-none d-md-block">
        <h5>Pizza especial</h5>
        <p>Pizza de jamon, chorizo, pepperoni y champiñones.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/mollete.jpg" class="d-block w-100" alt="Pizza Mollete">
      <div class="carousel-caption d-none d-md-block">
        <h5>Pizza mollete</h5>
        <p>Pizza base de frijoles, con queso, chorizo y tocino.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
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
    <section style="background-color: #ccc;" id="fot">
    <div class="footer">
    <div class="main position-relative d-flex">
        <div class="colu col-6 col-lg-4">
            <h4>ENLACES</h4>
            <ul class="bx-ul">
                <li><a href="#nav"><i class='bx bxs-home'></i>INICIO</a></li>
                <li><a href="#views/menu-pizza.php"><i class='bx bxs-food-menu'></i>MENU</a></li>
                <li><a href="#servicios"><i class='bx bxs-check-square'></i>SERVICIO</a></li>
                <li><a href="https://www.facebook.com/pizzastoystorreon/"><i class='bx bxl-facebook-square'></i>FACEBOOK</a></li>
            </ul>
        </div>
        <div class="colu col-6 col-lg-6c offset-lg-2">
            <h4>DIRECCIONES DE SUCURSALES</h4>
            <?php
            $db = new Database();
            $db->conectarDB();
            $cadena = "SELECT ID_SUC,NOMBRE,DIRECCION,TELEFONO FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
            $reg = $db->seleccionar($cadena);
            echo "<ul class='bx-ul text-start'>
            <li>";
              foreach ($reg as $sucursal)
              {
                echo "<form method='post'>
                <a type='button' class='btn-sm btn-sucursal' data-id='{$sucursal->ID_SUC}' data-nombre='{$sucursal->NOMBRE}' data-direccion='{$sucursal->DIRECCION}' data-telefono='{$sucursal->TELEFONO}' data-bs-toggle='modal' data-bs-target='#sucu'>
                <i class='bx bxs-map'></i>{$sucursal->NOMBRE}
                </a>
                </form>";
              }             
            echo "</ul>";
            $db->desconectarDB();
            ?>
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
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $db = new Database();
                    $db->conectarDB();

                    extract($_POST);

                    $verificacionExitosa=$db->verifica($correo, $password);
                    if($verificacionExitosa)
                    {
                      echo "<script>alert('Bienvenido: ".$_SESSION["usuario"].");</script>";
                      switch ($_SESSION["rol"])
                      {
                          case 1: echo "<script>window.location.href = 'views/puntoventa.php';</script>";
                              break;
                          case 2:
                                echo "<script>window.location.href = 'index.php';</script>";
                                break;
                          case 3: echo "<script>window.location.href = 'views/puntoventa.php';</script>";
                              break;
                          default:
                              break;
                      }

                    }else
                    {
                      echo "<script>alert('Usuario o contraseña incorrectos');</script>";
                    }
                }
                ?>
                <form method="post">
                    <label for="Nombre" class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" required>
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                    <br>
                    <span style="color: black;">¿No tienes una cuenta?</span>  <a data-bs-toggle="modal" data-bs-target="#register">Registrate</a>
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
                <form action="scripts/registrarse.php" method="POST" onsubmit="return validateForm()">
                    <label for="Nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                    <label for="password" class="form-label">Contraseña (8 o más caracteres)</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                    <label for="calle" class="form-label">Direccion</label>
                    <input type="text" class="form-control" required name="calle" placeholder="Calle y numero"><br>
                    <input type="text" class="form-control" required name="colonia" placeholder="Colonia"><br>
                    <input type="text" class="form-control" required name="cp" placeholder="Codigo postal"><br>
                    <label for="celular" class="form-label">Telefono (10 dígitos)</label>
                    <input type="tel" name="telefono" class="form-control" required inputmode="numeric" required pattern="[0-9]{10}" oninput="filterNonNumeric(event)">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="correo" placeholder="Obligatorio" required class="form-control">
                    <span style="color: red;"><?php if(isset($correoError)) echo $correoError; ?></span>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
  <!-- MODAL SUCURSALES -->
<div class="modal fade" id="sucu" tabindex="-1" aria-labelledby="sucursales" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">SUCURSAL <span id="sucursal-nombre"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Dirección: <span id="sucursal-direccion"></span></p>
                <p>Teléfono: <span id="sucursal-telefono"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".btn-sucursal");
        buttons.forEach(button => {
            button.addEventListener("click", function () {
                const nombre = this.getAttribute("data-nombre");
                const direccion = this.getAttribute("data-direccion");
                const telefono = this.getAttribute("data-telefono");

                document.getElementById("sucursal-nombre").textContent = nombre;
                document.getElementById("sucursal-direccion").textContent = direccion;
                document.getElementById("sucursal-telefono").textContent = telefono;
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./src/validaciones.js"></script>
</body>
</html>