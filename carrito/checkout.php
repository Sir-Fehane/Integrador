<?php
// include database configuration file
include 'dbConfig.php';

// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;

// redirect to home if cart is empty
if($cart->total_items() <= 0){
    header("Location: index.php");
}

// set customer ID in session
$nomusu=$_SESSION['IDUSU'];
$_SESSION['sessCustomerID'] = $nomusu;

// get customer details by session customer ID
$query = $db->query("SELECT * FROM USUARIOS WHERE ID_USUARIO = ".$_SESSION['sessCustomerID']);
$custRow = $query->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{width: 100%;padding: 50px;}
    .table{width: 65%;float: left;}
    .shipAddr{width: 30%;float: left;margin-left: 30px;}
    .footBtn{width: 95%;float: left;}
    .orderBtn {float: right;}
    </style>
</head>
<body>
<form class="d-flex" action="" method="post" id="sucursal">
          <?php
            $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
            $reg = $dbase->seleccionar($cadena);
            echo "<div class='me-2'>
            <select name='sucursal' class='form-select'>
            <option value='0'>Seleccionar sucursal...</option>";
            foreach ($reg as $value)
            {
              echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
            }
            echo "</select>
            </div>";
            $dbase->desconectarDB();
            ?>
          <button type="submit" class="btn btn-warning">Elegir</button>
        </form>
<div class="container">
    <h1>Order Preview</h1>
    <table class="table">
    <thead>
        <tr>
            <th>Productos</th>
            <th>Precios</th>
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
    <div class="shipAddr">
        <h4>Detalles de la orden</h4>
        <p><?php echo $custRow['NOMBRE']; ?></p>
        <p><?php echo $custRow['CORREO']; ?></p>
        <p><?php echo $custRow['TELEFONO']; ?></p>
        <p><?php echo $custRow['DIRECCION']; ?></p>
        <p><?php echo $_SESSION['NombSuc']?></p>
    </div>
    <div class="footBtn">
        <a href="../views/menu-pizza.php" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a>
        <a href="cartAction.php?action=placeOrder" class="btn btn-success orderBtn">Place Order <i class="glyphicon glyphicon-menu-right"></i></a>
    </div>
</div>
</body>
</html>