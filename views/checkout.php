<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/check.css">
</head>

<body>
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
              <a class="nav-link" href="cierre.php">Cierre</a>
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
        </div>
      </div>
    </nav>
    <?php
    include '../class/database.php';
    $conexion = new database();
    $conexion->conectarDB();
    $nombreCliente = isset($_POST['nombre-cliente']) ? $_POST['nombre-cliente'] : '';
    $domCliente = $_POST["dom-cliente"];
    $telCliente = $_POST["tel-cliente"];
    $notes = $_POST["notes"];
    $notas = "Nombre: $nombreCliente, Domicilio: $domCliente, Teléfono: $telCliente, Nota: $notes";
    $_SESSION['cliente'] = $nombreCliente;
    $_SESSION['domclien'] = $domCliente;
    $_SESSION['telclien'] = $telCliente;
    $_SESSION['notas'] = $notes;
    $totalGeneral = isset($_POST['total_general']) ? $_POST['total_general'] : 0;
    ?>
    <div class="container" id="cuerpo11">
      <div class="row">
        <div class="col-sm-12">
          <h3 align="center">Detalle orden</h3>
        </div>
      </div>
      <div class="row" id="Renglon">
        <div class="col-lg-12 table-responsive">
          <?php if (isset($_SESSION['carrito'])) {?>
          <table class="table align-middle table-sm">
          <thead class="table-light">
              <tr>
                  <td colspan="3" class="text-center">
                      
                  <form method="post" action="../scripts/completarpago.php">
                      <label for="forma_pago">Forma de pago:</label>
                      <select name="forma_pago" id="forma_pago"  class="form-select form-select-md mb-3 text-center" >
                          <option value="EFECTIVO">Efectivo</option>
                          <option value="TARJETA">Tarjeta</option>
                      </select>           
                  </td>
                  <td colspan="2" class="text-center">
                      <label for="tipo_pedido">Tipo de pedido:</label>
                      <select name="tipo_pedido" id="tipo_pedido"  class="form-select form-select-md mb-3 text-center">
                          <option value="AQUI">Para comer aqui</option>
                          <option value="LLEVAR">Para llevar</option>
                      </select>
                  </td> 
              </tr>
              <tr>
                  <th class="text-center">Producto</th>
                  <th class="text-center">Tamaño</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Precio unitario</th>
                  <th class="text-center">Subtotal</th>
              </tr>
            </thead>
                  <?php foreach ($_SESSION['carrito'] as $producto) { ?>
                  <tbody>
                  <tr>  
                      <td class="text-center"><?php echo $producto['titulo']; ?></td>
                      <td class="text-center"><?php echo $producto['tamaño']; ?></td>
                      <td class="text-center"><?php echo $producto['cantidad']; ?></td>
                      <td class="text-center"><?php echo $producto['precio']; ?></td>
                      <td class="text-center"><?php echo $producto['precio'] * $producto['cantidad']; ?></td>
                  </tr>
              </tbody>
              <?php } ?>
              <tfoot>
                  <tr>
                      <td colspan="4" class="table-light" ></td>
                      <td colspan="1">
                      <h3>Total: $<?php echo $totalGeneral; ?></h3>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="3" class="table-light"> <a href="../views/puntoventa.php" class="btn btn-lg btn-warning d-grid gap-1">Regresar</a> </td>
                      <td colspan="2" class="text-center">
                      <div class="d-grid gap-1">
                        <form action="../scripts/completarpago.php" method="post">
                        <input type="hidden" name="totalfinal" value="<?php echo $totalGeneral; ?>">
                          <button type="submit" class="btn btn-lg btn-success" id="bloqueo" name="pagar" onclick="cambiarContenido()">Pagar</button>
                          </form>
                      </div>
                      </td>
                  </tr>
              </tfoot>
            </table>
         </div>
       </div>
     </div>
   </div>  
    <?php } else {	
        echo "El carrito está vacío.";
    } ?>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    var boton = document.getElementById("bloqueo");
    var form = document.querySelector("form");

    form.addEventListener("submit", function() {
        boton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Presione regresar...';

    });
});
</script>

<script>
function cambiarContenido() {
    var boton = document.getElementById("bloqueo");
    var form = document.querySelector("form");

    // Deshabilitar el botón después de hacer clic
  
    

    // Cambiar el contenido del botón para mostrar una animación o mensaje
    boton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

    // Ocultar el botón después de un breve retraso (opcional)
    setTimeout(function() {
        boton.style.display = "none";
    }, 1000);

    // Aquí puedes realizar otras acciones si es necesario
}
</script>
    <script src="../js/bootstrap.bundle.js"></script>
  </body>
</html>