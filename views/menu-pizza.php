<?php
// include database configuration file
session_start();
include '../class/database.php';
$dbase= new Database();
$dbase->conectarDB();
//if(!isset($_SESSION['SUCURSALCHIDA']) && isset($_SESSION['IDUSU'])){include "../scripts/direccion.php";}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="shortcut icon" href="../img/pizza.png">
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/boot.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Toys Pizza</title>
</head>
<body>
    <!--Navbar-->
<nav class="navbar navbar-expand-lg he" id="nav">
    <div class="container-fluid">
        <a class="navbar-brand logo" href="#">
            <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
            Toy's Pizza
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active navtext" aria-current="page" href="../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtext" href="#">Menu</a>
                </li>
                <li class='nav-item navtext'>Sucursal seleccionada: </li>
                <li class="nav-item dropdown">
                    <a class='nav-link dropdown-toggle text-white' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><?php if(isset($_SESSION['SUCURSALCHIDA'])){echo $_SESSION['SUCURSALCHIDA'];} else{echo"Selecciona sucursal";} ?></a>
                    <ul class="dropdown-menu">
                        <?php 
                        //Sucursales en Navbar
                        $Sucs=$dbase->seleccionar("SELECT * FROM SUCURSALES WHERE ESTADO = 'ACTIVO'");
                        foreach($Sucs as $x)
                        {
                            echo "<form action='../scripts/jala.php' method='POST'><input type='hidden' name='nombre' id='nombre' value='$x->NOMBRE'><button type='submit' class='btn btn-warning'>Sucursal: '".$x->NOMBRE."'</button></form>";
                        }
                        ?>
                    </ul>
                </li>
                <?php
                if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3) {
                    echo '<li class="nav-item">
                              <a class="nav-link navtext" href="../views/puntoventa.php">Punto de Venta</a>
                          </li>';
                }
                ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
            <a href="../carrito/viewCart.php" title="Ver carrito"  id="carro"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAA/5JREFUWEedWE2IFEcYfV/PrhA96kHQgxhCdqpbBIWAJHjwIDkkxO3NHhZPejAK4j2QgJAcchMMEdaDGxAWyWZ6kmMCEQQDguLB2a5ZQSIeFMGbIBF1+pPq7p2p6q7qqd6+7Ex3/bzvfe+9rlnCli8CwK1mT2aYc/Vv6rPlIhAY3H7PfC37NNdiFXBVdK1B5Av4Id8aQ+Usny18sNTWmbK+0TIRpxfHfDP/T4SbaRLd9W5BYxW6DMzPuhargCwq5RWZRKdbqddjsItd0osScWq1Tca0tNEXN6yC9emb1TZ26RUMlajylpVXRnQ4YP6i/Pqv7IefKfHm7mvw0njvrQJ1tV0sprsxwlMAgRqTMR0Y9sX6BIsZDbqDJqB1anxsUnBjFqV9F3H6G8CLahgT/TLsifPTAblyyNzJDroCqAqtuyCPEvOtvDbGSxAuufQ6qV81lCyoyvvaAkz06m0w++ujtY9ebN5uZEgNEnGq2hQWE+qLOg1VVqHXXANdTL4rk/ATE5ArvQB0F+Q5Yr6iTzCs6Ao6n4AtQD+RSbTPypCt2sNf3tv+evaDFwxsd7LhfH+ZM6yyZvwk++G3xUhllOJv3g2XU0Wc/gwgF7SfV2xr2ts96nT2P1ybe+zNkBoYnRh8mAXBI7Neywa6bvyQ35FJeEQfqom6mSaxkP4DxjHTvO60LQ4ALhNw3hwGzsokXNbdbbTMrpECaDQ/iDMKek06anac/jQH+npmx7tdD64ffFUt0i0MncuLHIgHUiX37tYRUEOqGMKNNImWqrr0ZkhN7MbyOwL/0MyST1YxiPB52ov+qq5lBGPjRgTMnRju7FD2nIEZW2X+J2x+NkzCvQyqTTGOH7UIsNzozstVIq5RXSumyWVG9piKcQKaYDFNGcaDTxl020Z1nSH7e62aPXVRl3dcwajbUjlOzKcpCMLe4qlWvyOT6IjX2356lhXpIeL1JQatNo6vph0X2QPgZJpEq9Vz9Ca7Rct8XoQVXkMFiunjVhFAPJBJ1Gv6fenhslqpeoMtXZvOc9WhTg3ZnWKnT8TpMginMMJ/wUxwYf337t82TUVfD49no+wyAuwHY0Um4TfegPxqgxL1KRCujQEwHg774dxYB+Nf/QQxv74BQtladTjHaflHuOKKCY+W1euuJTbxW9mLttnOL2IhfQPG7CYrGdH3w574sdomvZjmN4Hl6dzi8EAwGt0HKE9sAFc3WzFuR0l32dozhZD5XdbpHNpYEwPXf04Mhqbn0ASdAoURfxUwP5V9Swu0QlSLmWgPd+jPjbXuYPzIopFWL1c3lT7qc/+ez9fVvGPdp7aFD33eeWauXs3C1hqqH6zdG7jE69q0pctcIdm+JhfQ93JBvTYjB6UlAAAAAElFTkSuQmCC"/> </a>
            </li>
                              <div class="dropdown dropdown-center btn-group dropstart">
                    <li class="nav-item navtext">
                        <div class="container">
                            <div class="d-flex justify-content">
                  <?php
                    if(isset($_SESSION["usuario"]))
                    {
                      $usuario1 = $_SESSION['correo'];
                      $consulta1 = "SELECT U.ID_USUARIO AS ID, U.NOMBRE AS 'NOMBRE', U.DIRECCION AS 'DIRECCION', U.TELEFONO AS 'TELEFONO', U.CORREO AS 'CORREO',
                      U.ESTADO, U.img_chidas FROM USUARIOS U
                      WHERE CORREO = '$usuario1'";
                      $tabla = $dbase->seleccionar($consulta1);
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
                                  <li><a class='dropdown-item text-black' href='../views/mispedidos.php'>Ver mis pedidos</a></li>
                                  <li><a class='dropdown-item text-black' href='../views/verperfilv1.php'>Ver perfil</a></li>
                                  <li><a class='dropdown-item text-black' href='../scripts/cerrarSesion.php'>Cerrar sesión</a></li>
                                  </ul>
                                  </li>";
                    } elseif ($registro->ESTADO == 'INACTIVO') {
                        header("Location: ../scripts/verificar_codigo.php");
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
            </ul>
        </div>
    </div>
</nav>
      <!--SUB Barra navegacion-->
      <ul class="nav nav-tabs justify-content-center nav-fill">
        <li class="nav-item">
          <a class="nav-link active" href="#">Menu</a>
        </li>
      </ul>
      <section>
<!--Productos-->
    <?php 
        $TAMAÑOS= $dbase->seleccionar("SELECT PRODUCTOS.TAMANO FROM PRODUCTOS WHERE PRODUCTOS.ESTADO='ACTIVO' GROUP BY PRODUCTOS.TAMANO");
        foreach($TAMAÑOS as $tm){ 
          if (isset($_SESSION['SUCURSALCHIDA'])){
          $consu="SELECT PRODUCTOS.CODIGO ,PRODUCTOS.NOMBRE, PRODUCTOS.PRECIO, PRODUCTOS.DESCRIPCION, PRODUCTOS.img_prod FROM PRODUCTOS 
          INNER JOIN PROD_SUC ON PROD_SUC.PRODUCTO = PRODUCTOS.CODIGO
          INNER JOIN SUCURSALES ON SUCURSALES.ID_SUC=PROD_SUC.SUCURSAL
          WHERE PRODUCTOS.ESTADO='ACTIVO' AND PROD_SUC.ESTADO='DISPONIBLE' AND SUCURSALES.NOMBRE='".$_SESSION['SUCURSALCHIDA']."' AND PRODUCTOS.TAMANO ='".$tm->TAMANO."'order BY PRODUCTOS.TAMANO DESC";
          }
          else
          {
            $consu="SELECT * FROM PRODUCTOS WHERE TAMANO='".$tm->TAMANO."' AND PRODUCTOS.ESTADO='ACTIVO' ORDER BY PRODUCTOS.TAMANO DESC";
          }   
        $PIZZAS=$dbase->seleccionar($consu);
         ?>
      <div class="container">
    <div id="products" class="row">
      <h3 class="mt-5"><?php echo $tm->TAMANO ?></h3>
      <?php foreach($PIZZAS as $row){?>
      <div class="carta col-12 col-lg-4">
            <div class="face front">
            <img src="<?php echo $row->img_prod ?>">
            <h3><?php echo $row->NOMBRE; ?></h3>
            </div>
            <div class='face back'>
            <h3><?php echo $row->NOMBRE; ?></h3>
            <p><?php echo $row->DESCRIPCION; ?></p>
            <p><?php echo $tm->TAMANO;?></p>
            <div class='linka d-flex mb-lg-3'>
            <div class="row">
                        <div class="col-md-6">
                            <p class="lead"><?php echo '$'.$row->PRECIO.' MX'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn butn-menu" href="../carrito/cartAction.php?action=addToCart&id=<?php echo $row->CODIGO; ?>">Agregar</a>
                        </div>
                    </div>
            </div>
            </div>
            </div>
            <?php } ?>
          </div>
        </div>
      
      <?php }?>
    
</section>
<!--Footer-->
<section style="background-color: #ccc;" id="fot">
    <div class="footer">
    <div class="main position-relative d-flex">
        <div class="colu col-6 col-lg-4">
            <h4>ENLACES</h4>
            <ul class="bx-ul">
                <li><a href="../index.php"><i class='bx bxs-home'></i>INICIO</a></li>
                <li><a href="#"><i class='bx bxs-food-menu'></i>MENU</a></li>
                <li><a href="#servicios"><i class='bx bxs-check-square'></i>SERVICIO</a></li>
                <li><a href="https://www.facebook.com/pizzastoystorreon/"><i class='bx bxl-facebook-square'></i>FACEBOOK</a></li>
            </ul>
        </div>
        <div class="colu col-6 col-lg-6c offset-lg-2">
            <h4>DIRECCIONES DE SUCURSALES</h4>
            <?php
            $cadena = "SELECT ID_SUC,NOMBRE,DIRECCION,TELEFONO FROM SUCURSALES WHERE ESTADO = 'ACTIVO'";
            $reg = $dbase->seleccionar($cadena);
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
            $dbase->desconectarDB();
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
                          case 1: echo "<script>window.location.href = '../views/puntoventa.php';</script>";
                              break;
                          case 2:
                                echo "<script>window.location.href = '../index.php';</script>";
                                break;
                          case 3: echo "<script>window.location.href = '../views/puntoventa.php';</script>";
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
                <form action="../scripts/registrarse.php" method="POST">
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
<script src="../src/validaciones.js"></script>
</body>
</html>