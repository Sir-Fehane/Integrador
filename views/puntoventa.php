<?php
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
              <a class="nav-link active" aria-current="page" href="">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cocina.PHP">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="cierre.php">Cierre</a>
            </li>
            <li>
              <a class="nav-link" href="solicitar.php">Solicitar</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="verperfilv.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
      <div class="div" id="cuerpo1">
        <div class="row" id="renglon">
        <?php
        include '../class/database.php';
        $conexion = new database();
        $conexion->conectarDB();
        $consulta ="SELECT PRODUCTOS.NOMBRE as N, PRODUCTOS.CODIGO as ID, PRODUCTOS.PRECIO as PR FROM PRODUCTOS GROUP BY PRODUCTOS.NOMBRE";
        $reg = $conexion->seleccionar($consulta);        
        foreach($reg as $value){ ?>
          <div class="col-12 col-md-5 col-lg-4">
          <button class="btn card" data-bs-toggle="modal" data-bs-target="#modal<?php echo $value->ID; ?>" data-modal-target="modal<?php echo $value->ID; ?>" id="item" data-titulo="<?php echo $value->N; ?>" data-tamaño="">   
                  <span class="titulo-item"><?php echo $value->N; ?></span>
                  <img src="../img/pepe.jpg" class="img-item"/>
              </button>
          </div>
          <?php } ?>
        </div>
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
                  $size = "SELECT TAMANO as T, PRECIO as PR FROM PRODUCTOS WHERE PRODUCTOS.NOMBRE = '$value->N'";
                  $sizes = $conexion->seleccionar($size);
                  echo "<label for='tamaño'>Tamaño</label>";
                  echo "<select name='tamaño' class='form-select tamaño' data-precio='0'>";
                  echo "<option value=''>SELECCIONA UNA OPCION</option>";
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
                        <button type="submit" class="btn btn-primary" onclick="actualizarCampos(<?php echo $value->ID; ?>)">Guardar cambios</button>
            </div>
          </div>
        </div>
        </form>
      </div>
      <?php } ?>

    <!--CARRITOOOO-->
    <div class="offcanvas offcanvas-end offcanvas-w-75" data-bs-scroll="true" tabindex="-1" id="carrito" aria-labelledby="offcanvasWithBothOptionsLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">
          Resumen de compra
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <?php
              $totalFinal = 0;
        // Verificar si el carrito tiene productos
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {

          ?>
          <table class="table">
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
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                  </td>
                </tr>
                
                <?php
                if (isset($_POST['index']) && is_numeric($_POST['index'])) {
                  $index = intval($_POST['index']);
              
                  // Verificar si el índice existe en el carrito
                  if (isset($_SESSION['carrito'][$index])) {
                      // Eliminar el ítem del carrito utilizando unset()
                      unset($_SESSION['carrito'][$index]);
              
                      // Reorganizar los índices para evitar huecos en el array
                      $_SESSION['carrito'] = array_values($_SESSION['carrito']);
              
                      // Recalcular el total después de eliminar el producto
                      $totalFinal = 0;
                      foreach ($_SESSION['carrito'] as $producto) {
                          $subtotal = $producto['precio'] * $producto['cantidad'];
                          $totalFinal += $subtotal;
                      }
                  }
              }
              }
              ?>
            </tbody>
          </table>
        <?php
        } else {
          // Mostrar mensaje cuando el carrito está vacío
          echo "<p>El carrito está vacío</p>";
        }
        ?>
          <div id="total" class="mb-3">
            <span>Total: $<?php echo number_format($totalFinal, 2); ?></span> 
          </div>
        <div>
          <button class="btn btn-primary" type="button">Proceder al pago</button>
          <a type="button" class="btn btn-primary" href="../scripts/borrarcarro.php">Vaciar carrito</a>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../src/scripts/app.js" defer></script>
  </body>
</html>
