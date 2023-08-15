<?php
include '../class/database.php';
$conexion = new database();
$conexion->conectarDB();
session_start();
if(!isset($_SESSION['rol']))
{
 header('location: ../index.php');
}
else
{
  if ($_SESSION["rol"] == 1) { 
    header("Location: admin.php");
    exit;
  } elseif ($_SESSION["rol"] == 3) { 
    if (basename($_SERVER['PHP_SELF']) === 'puntoventa.php') {    
    } else {
        header("Location: puntoventa.php");
        exit;
    }
  } elseif ($_SESSION["rol"] == 2) { 
    header("Location: ../index.php");
    exit;
  }
}
$cons="SELECT SUCURSALES.ID_SUC FROM SUCURSALES INNER JOIN EMPLEADO_SUCURSAL ON EMPLEADO_SUCURSAL.SUCURSAL=SUCURSALES.ID_SUC INNER JOIN USUARIOS ON USUARIOS.ID_USUARIO=EMPLEADO_SUCURSAL.EMPLEADO WHERE USUARIOS.ID_USUARIO=".$_SESSION["IDUSU"]."";
$resultadocons=$conexion->seleccionar($cons);
foreach($resultadocons as $abc)
{
  $_SESSION['IDSUCUR']=$abc->ID_SUC;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toy's Pízza</title>
    <link rel="stylesheet" href="../css/style.css"/>
    <link
      rel="stylesheet"
      href="../css/bootstrap.min.css"
    />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script type="text/javascript">

		function tiempoReal()
		{
			var tabla = $.ajax({
				url:'tablaConsulta.php',
				dataType:'text',
				async:false
			}).responseText;

			document.getElementById("miTabla").innerHTML = tabla;
		}
		setInterval(tiempoReal, 1000);
		</script>
<script type="text/javascript">
function tiempoReal2()
{
  var tabla = $.ajax({
    url:'tablaConsultaT.php',
    dataType:'text',
    async:false
  }).responseText;

  document.getElementById("miTabla2").innerHTML = tabla;
}
setInterval(tiempoReal, 1000);
</script>
  </head>      
  <body>
    <!--Header/navbar-->
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
            <li class="nav-item">
              <a class="nav-link" href="cocina.PHP">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="pendientes.php">Pendientes</a>
            </li>
            <li>
              <h6 id="miTabla"></h6>
            </li>
            <li>
              <a class="nav-link" href="terminadas.php">Terminadas</a>
            </li>
            <li>
              <h6 id="miTabla2"></h6>
            </li>
            <li>
              <a class="nav-link" href="cierre.php">Cierre</a>
            </li>
            <li>
              <a class="nav-link" href="solicitar.php">Solicitar</a>
            </li>
            <li>
              <a class="nav-link" href="entrada.php">Entrada</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="verperfilv1.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Perfil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../scripts/cerrarSesion.php">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <button class="btn btn-outline" id="btn-carrito" type="button" data-bs-toggle="offcanvas" data-bs-target="#carrito" aria-controls="offcanvasScrolling">Resumen de compra</button>
          </form>
        </div>
      </div>
    </nav>

    <!--Cuerpo de la pagina-->
    <div class="container" id="cuerpo">
        <div class="row" id="renglon">
        <?php
        $consulta ="SELECT PRODUCTOS.NOMBRE as N, PRODUCTOS.CODIGO as ID, PRODUCTOS.PRECIO as PR, PRODUCTOS.img_prod as IMG FROM PRODUCTOS WHERE PRODUCTOS.ESTADO = 'ACTIVO' GROUP BY PRODUCTOS.NOMBRE";
        $reg = $conexion->seleccionar($consulta);        
        foreach($reg as $value){ ?>
          <div class="col-6 col-md-5 col-lg-4">
          <button class="btn justify-content-center" data-bs-toggle="modal" data-bs-target="#modal<?php echo $value->ID; ?>" data-modal-target="modal<?php echo $value->ID; ?>" id="item" data-titulo="<?php echo $value->N; ?>" data-tamaño="" style="height:225px">   
          <?php $imagen = $value->IMG; ?>
                  <span class="titulo-item"><?php echo $value->N; ?></span>
                  <div class="d-lg-none d-block">
                      <img src="<?php echo $imagen;?>" class="img-item" style="width: 125px; height:100px">
                  </div>
                  <div class="d-none d-lg-block">
                      <img src="<?php echo $imagen;?>" class="img-item" style="width: 250px; height:150px">
                  </div>
              </button>
          </div>
          <?php } ?>
      </div>
    </div>
    <!-- CONFIGURAR -->
    <?php foreach ($reg as $value) { ?>
    <div class="modal fade" id="modal<?php echo $value->ID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formulario_<?php echo $value->ID ?>" name="formulario" method="post" action="../scripts/cart.php?ID">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $value->N ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
              <?php
                  $size = "SELECT TAMANO as T, PRECIO as PR, CODIGO as ID FROM PRODUCTOS WHERE PRODUCTOS.NOMBRE = '$value->N'";
                  $sizes = $conexion->seleccionar($size);
                  echo "<label for='tamaño'>Tamaño</label>";
                  echo "<select name='tamaño' class='form-select tamaño' data-precio='0'>";
                  echo "<option value='' >SELECCIONA UNA OPCION</option>";
                  foreach($sizes as $reg2)
                  {
                    echo "<option value='" . $reg2->T . "' data-precio='" . $reg2->PR . "'>" . $reg2->T . " - $" . $reg2->PR . "</option>";
                  }
                  ?>
                  </select>
                  <br><br>
                  <label for="cantidad">Cantidad: </label>
                  <input type="number" min="1"  name="cantidad" class="cantidad" placeholder="0" value="1"></input>
                  <br><br>
                  <label for="subtotal">Subtotal: </label>
                  <h5><span class="subtotal">0</span></h5>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        <input type="hidden" name="titulo" value="<?php echo $value->N; ?>">
                        <input type="hidden" name="precio" value="0">
                        <input type="hidden" name="ID" value="<?php echo $value->ID; ?>">
                        <input type="hidden" name="tamaño" value="">
                        <button type="submit" class="btn btn-primary" onclick="actualizarCampos(<?php echo $value->ID; ?>)" id="agregar">Agregar</button>
            </div>
          </div>
        </div>
        </form>
      </div>
      <?php } ?>

    <!--CARRITOOOO-->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="carrito" aria-labelledby="offcanvasWithBothOptionsLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel" align="center">
          Resumen de compra
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="row">
        <div class="col-11 col-lg-11" style="margin-left: 4%">
        </div>          
      </div>
      <div class="offcanvas-body">
      <div class="row table-responsive d-flex flex-column justify-content-between" style="height: 100%; padding:5px;">
        <?php
        $totalFinal = 0;
        
        // Verificar si el carrito tiene productos
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        ?>

          <table class="table table-sm text-center">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Tamaño</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Recorremos los productos en el carrito y los mostramos en la tabla
              foreach ($_SESSION['carrito'] as $index => $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $totalFinal += $subtotal; // Sumar el subtotal al total final
              ?>
                <tr>
                  <td><?php echo $producto['titulo']; ?></td>
                  <td><?php echo $producto['tamaño']; ?></td>
                  <td>$<?php echo $producto['precio']; ?></td>
                  <td><?php echo $producto['cantidad']; ?></td>
                  <td>$<?php echo $subtotal; ?></td>
                  <td>
                    <form action="../scripts/eliminar_producto.php" method="post">
                      <input type="hidden" name="index" value="<?php echo $index; ?>">
                      <button type="submit" class="btn btn-danger" name="eliminar"><i class='bx bxs-trash'></i></button>
                    </form>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
            </table>             
        </div>      
      </div>      
      <?php
      } else {
        // Mostrar mensaje cuando el carrito está vacío
        echo "<h3 align='center'>(vacío)</h3>";
      }
      ?>

      <form method="POST" action="./checkout.php">
      <div class="row">
        <div class="col-12 col-lg-12" >
        <input type="text" class="form-control"  name="nombre-cliente" id="nombre-cliente" placeholder="Nombre" require>
          <input type="text" class="form-control"  name="dom-cliente" id="dom-cliente" placeholder="Domicilio">
          <input type="text" class="form-control"  name="tel-cliente" id="tel-cliente" placeholder="Telefono">
          <input type="text" class="form-control"  name="notes" id="notes" placeholder="Notas">
        </div>
      </div>
      <div id="total" class="mb-3" style="padding-left: 5%;">
        <strong>Total: $<?php echo number_format($totalFinal, 2); ?></strong>
        <input type="hidden" name="total_general" value="<?php echo number_format($totalFinal, 2); ?>">
      </div>
      <div class="btn-group" role="group" aria-label="Basic example" style="padding-left: 9%; padding-bottom: 5%">
        <button class="btn btn-success btn-lg" type="submit" name="btn_proceder_pago" <?php echo (empty($_SESSION['carrito']) ? 'disabled' : ''); ?>>Proceder al pago</button>
        <a type="button" class="btn btn-dark btn-lg" href="../scripts/borrarcarro.php">Vaciar</a>
      </div>
    </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../src/app.js" defer></script>
  </body>
</html>
