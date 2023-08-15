<?php
// include database configuration file
// initializ shopping cart class
include 'Cart.php';
include '../class/database.php';
$db= new Database();
$db->conectarDB();
$cart = new Cart;
$horainicio="10:00";
$horacierre="20:00";
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
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        
        if (!isset($_POST["sucursal"])) 
        {
            $_SESSION['IDSUCURSAL']=0;
            $_SESSION['NombSuc']="Selecciona sucursal!";
        }
        else
        {
            $sucursal = $_POST["sucursal"];
            $_SESSION['IDSUCURSAL']=$sucursal;
            $putrow=$db->selecsinall("SELECT NOMBRE FROM SUCURSALES WHERE ID_SUC=".$sucursal."");
            $_SESSION['NombSuc']=$putrow['NOMBRE'];
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Toy's Pizza</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/carro.css">
</head>
<body>
<?php
    if ($horaactual >= $horainicio && $horaactual <= $horacierre)
    {
    ?>
    <form class="d-flex" action="" method="post" id="sucursal">
          <?php
            $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
            $reg = $db->seleccionar($cadena);
            echo "<div class='me-2'>
            <h4>Selecciona sucursal</h4>
            <select name='sucursal' class='form-select'>";
            
            foreach ($reg as $value)
            {
              echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
            }
            echo "</select>
            </div>";
           
            ?>
          <button type="submit" class="btn btn-warning">Elegir</button>
        </form>
<div class="container">
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
    <div class="shipAddr">
        <h4>Detalles de la orden</h4>
        <p><?php echo $custRow['NOMBRE']; ?></p>
        <p><?php echo $custRow['CORREO']; $_SESSION['CorreoUsua']=$custRow['CORREO']; ?></p>
        <p><?php echo $custRow['TELEFONO']; ?></p>
        <p><?php echo $custRow['DIRECCION']; ?></p>
        <p>
        <?php if (!isset($_SESSION['NombSuc']))
        {
            echo"<p>Porfavor seleccione una sucursal</p>";
        }
        else
        {
            echo $_SESSION['NombSuc'];
        } 
        ?>
        </p>
    </div>
    <div class="footBtn">
        <a href="../views/menu-pizza.php" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a>
        <?php 
        if (!isset($_SESSION['NombSuc']))
        {
            echo"<p>Porfavor seleccione una sucursal</p>";
        }
        else
        {
        ?>
        <a href="cartAction.php?action=placeOrder" class="btn btn-success orderBtn">Place Order <i class="glyphicon glyphicon-menu-right"></i></a>
        <?php }?>
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