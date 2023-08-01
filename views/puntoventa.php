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
  <?php 
    $carrito_mio = $_SESSION['carrito'];
    $_SESSION['carrito']=$carrito_mio;

    // contamos nuestro carrito
    if(isset($_SESSION['carrito'])){
        for($i=0;$i<=count($carrito_mio)-1;$i ++){
        if($carrito_mio[$i]!=NULL){ 
        $total_cantidad = $carrito_mio['cantidad'];
        $total_cantidad ++ ;
        $totalcantidad += $total_cantidad;
        }}}
    ?>
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
              <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="#">Cierre</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <button class="btn card" data-bs-toggle="modal" data-bs-target="#modal<?php echo $value->ID; ?>" id="item">   
                <span class="titulo-item"><?php echo $value->N; ?></span>
                <img src="./src/img/pepe.jpg" class="img-item"/>
            </button>
        </div>
        <?php } ?>   
        </div>
      </div>
    </div>
      <!-- CONFIGURAR -->
  <?php
  foreach($reg as $value){ ?>
<div class="modal fade" id="modal<?php echo $value->ID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formulario" name="formulario" method="post" action="../scripts/cart.php">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><input name="titulo" type="Hidden" value="<?php echo $value->N ?>"><?php echo $value->N ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
            $size="SELECT TAMAÑO FROM PRODUCTOS WHERE PRODUCTOS.NOMBRE = '$value->N' ";
            $sizes=$conexion->seleccionar($size);
            echo "<label for='tamaño'>Tamaño</label>";
            echo"<select name='tamaño' class='form-select'>";
            foreach($sizes as $reg2)
            {
              echo"<option value='".$reg2->TAMAÑO."'>".$reg2->TAMAÑO."</option>";
            }
            echo"</select>";
            echo "<br><br>";
            echo "<label for='cantidad'>Cantidad: </label>";
            echo "<input type='number' min='1' name='cantidad' id='cantidad' placeholder='1'></input>";
            echo "<br><br>";
            echo "<label for='precio'>Precio: </label>";
            echo "<input name='precio' id='precio' type='hidden' value='$value->PR'";
          ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
  </form>
</div>
<?php } ?>

    <!--CARRITOOOO-->
    <div
      class="offcanvas offcanvas-end"
      data-bs-scroll="true"
      tabindex="-1"
      id="carrito"
      aria-labelledby="offcanvasWithBothOptionsLabel"
    >
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">
          Resumen de compra
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body">
      <div>
					<div class="p-2">
						<ul class="list-group mb-3">
							<?php
							if(isset($_SESSION['carrito'])){
							$total=0;
							for($i=0;$i<=count($carrito_mio)-1;$i ++){
							if($carrito_mio[$i]!=NULL){
						
            ?>
							<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div class="row col-12" >
									<div class="col-6 p-0" style="text-align: left; color: #000000;"><h6 class="my-0">Cantidad: <?php echo $carrito_mio[$i]['cantidad'] ?> : <?php echo $carrito_mio[$i]['titulo']; // echo substr($carrito_mio[$i]['titulo'],0,10); echo utf8_decode($titulomostrado)."..."; ?></h6>
									</div>
									<div class="col-6 p-0"  style="text-align: right; color: #000000;" >
									<span   style="text-align: right; color: #000000;"><?php echo $carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad'];    ?> €</span>
									</div>
								</div>
							</li>
							<?php
							$total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
							}
							}
							}
							?>
							<li class="list-group-item d-flex justify-content-between">
							<span  style="text-align: left; color: #000000;">Total (EUR)</span>
							<strong  style="text-align: left; color: #000000;"><?php
							if(isset($_SESSION['carrito'])){
							$total=0;
							for($i=0;$i<=count($carrito_mio)-1;$i ++){
							if($carrito_mio[$i]!=NULL){ 
							$total=$total + ($carrito_mio[$i]['precio'] * $carrito_mio[$i]['cantidad']);
							}}}
							echo $total; ?> $</strong>
							</li>
						</ul>
					</div>
				</div>
      </div>
      <div>
        <button class="btn btn-primary" type="button">Proceder al pago</button>
        <a type="button" class="btn btn-primary" href="../scripts/borrarcarro.php">Vaciar carrito</a>
      </div>
    </div>
    <script src="../js/bootstrap.bundle.js"></script>
  </body>
</html>
