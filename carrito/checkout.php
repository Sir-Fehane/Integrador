<?php
// include database configuration file
// initializ shopping cart class
include 'Cart.php';
include '../class/database.php';
$db= new Database();
$db->conectarDB();
$cart = new Cart;
$horainicio="00:00";
$horacierre="23:00";
$horaactual=date("H:i");

// redirect to home if cart is empty
if($cart->total_items() <= 0){
    header("Location: index.php");
}

// set customer ID in session
$nomusu=$_SESSION['IDUSU'];
$_SESSION['sessCustomerID'] = $nomusu;

// get customer details by session customer ID
$custRow = $db->selecsinall("SELECT * FROM USUARIOS WHERE ID_USUARIO = ".$_SESSION['sessCustomerID']);
?>

<?php
$putrow=$db->selecsinall("SELECT ID_SUC FROM SUCURSALES WHERE NOMBRE='".$_SESSION['SUCURSALCHIDA']."'");
$_SESSION['IDSUCURSAL']=$putrow['ID_SUC'];   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Toy's Pizza</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/carro.css">
    <style>body{color:var(--text-color);background-image: url(../img/fondocar.jpg);background-repeat: repeat;background-size: auto;}</style>
</head>
<body>
<?php
    if ($horaactual >= $horainicio)
    {
    ?>

<div class="container col-lg-8 col-12">
    <h1>Confirmar pedido</h1>
    <table class="table">
    <thead>
        <tr>
            <th>Productos</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>
        <tr>
            <td><?php echo $item["name"]; ?></td>
            <td><?php echo '$'.$item["price"].' MX'; ?></td>
            <td><?php echo $item["qty"]; ?></td>
            <td><?php echo '$'.$item["subtotal"].' MX'; ?></td>
        </tr>
        <?php } }else{ ?>
        <tr><td colspan="4"><p>No hay nada que mostrar...</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Total <?php echo '$'.$cart->total().' MX'; ?></strong></td>
            <?php } ?>
        </tr>
    </tfoot>
    </table>
    </div>
    <div class="container vistap col-12 col-lg-12 d-inline-block">
    <div class="row align-items-center">
    <div class="shipAddr col-8 col-lg-8">
        <h3>Detalles de la orden</h3>
        <p><h4>Nombre:</h4> <br> <?php echo $custRow['NOMBRE']; ?></p>
        <hr>
        <p><h4>Correo:</h4> <br><?php echo $custRow['CORREO']; $_SESSION['CorreoUsua']=$custRow['CORREO']; ?></p>
        <hr>
        <p><h4>Telefono:</h4> <br><?php echo $custRow['TELEFONO']; ?></p>
        <hr>
        <p><h4>Sucursal: </h4><br>
        <?php if (!isset($_SESSION['SUCURSALCHIDA']))
        {
            echo"<p>Porfavor seleccione una sucursal</p>";
        }
        else
        {
            echo $_SESSION['SUCURSALCHIDA'];
        } 
        ?>
        </p>
    </div>

    <div class=" buttonspe col-lg-4">
        <a href="../views/menu-pizza.php" class="btn btn-warning"><i class='bx bx-chevron-left'></i>¡Continuar comprando!</a>
        <?php 
        if (!isset($_SESSION['SUCURSALCHIDA']))
        {
            
        }
        else
        {
        ?>
        <a href="cartAction.php?action=placeOrder" class="btn btn-success orderBtn">¡Ordenar!<i class='bx bx-chevron-right'></i></a>
        <?php }?>
    </div>
    </div>
    </div>
<?php
    } 
    else 
    {
        echo "<div class='alert alert-danger' role='alert'>
        ¡Lo sentimos!<br>
        Estamos cerrados :(<br>
        Nuestro horario de atención es de 11:00 AM a 08:00 PM.
        </div>";
    }
?>
    
</body>
</html>