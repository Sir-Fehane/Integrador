<?php
// include database configuration file
session_start();
include'../class/database.php';
$dbase= new Database();
$dbase->conectarDB();
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
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active navtext" aria-current="page" href="../index.php">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navtext" href="../views/menu-pizza.php">Menu</a>
              </li>
                </ul>
                <li class="nav-item">
            <a href="../carrito/viewCart.php" title="Ver carrito"><i class='bx bxs-cart'></i></a>
            </li>
              <li class="nav-item navtext">
                <div class="container">
                  <div class="d-flex justify-content">
                  <?php
                    if(isset($_SESSION["usuario"]))
                    {
                      $usuario1 = $_SESSION['usuario'];
                      $consulta1 = "SELECT U.ID_USUARIO AS ID, U.NOMBRE AS 'NOMBRE', U.DIRECCION AS 'DIRECCION', U.TELEFONO AS 'TELEFONO', U.CORREO AS 'CORREO',
                      U.ESTADO, U.img_chidas FROM USUARIOS U
                      WHERE NOMBRE = '$usuario1'";
                      $tabla = $dbase->seleccionar($consulta1);
                      foreach ($tabla as $registro)
                      {
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
          <a class="nav-link active" href="#">Menu</a>
        </li>
      </ul>
      <section>
<!--Productos-->
    <?php 
        $TAMAÑOS= $dbase->seleccionar("SELECT PRODUCTOS.TAMANO FROM PRODUCTOS WHERE PRODUCTOS.ESTADO='ACTIVO' GROUP BY PRODUCTOS.TAMANO");
        foreach($TAMAÑOS as $tm){ 
          $consu="SELECT * FROM PRODUCTOS WHERE TAMANO='".$tm->TAMANO."' AND PRODUCTOS.ESTADO='ACTIVO' ORDER BY PRODUCTOS.TAMANO DESC";   
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
            <p><?php echo $row->TAMANO;?></p>
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
                <li><a href="#nav"><i class='bx bxs-home'></i>INICIO</a></li>
                <li><a href="#views/menu-pizza.php"><i class='bx bxs-food-menu'></i>MENU</a></li>
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
                          case 1: echo "<script>window.location.href = 'views/puntoventa.php';</script>";
                              break;
                          case 2:
                                echo "<script>window.location.href = '../index.php';</script>";
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
                <input type="email" name="correo" placeholder="Obligatorio" required class="form-control">
                <div class="modal-footer">
                  <button type="submit" class="btn btn-warning">Registrar</button>
                </div>
              </form>
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
</body>
</html>