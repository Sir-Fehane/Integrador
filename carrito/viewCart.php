<?php
// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Toy's Pizza</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/carro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    input[type="number"]{width: 40%;}
    </style>
    <!--Script para impedir que se pongan numeros negativos-->
    <script>
    var numero = document.getElementById('numero');
    function comprueba(valor){
    if(valor.value < 0){
    valor.value = 1;}
}
    </script>
      <!--Script para evitar numeros mas grandes que 8-->
      <script>
    var numero = document.getElementById('numero');
    function comprueba2(valor){
    if(valor.value > 9){
    valor.value = 8;}
}
    </script>
<!--Script que no permite poner decimales-->
<script>
function filtro()
{
var tecla = event.key;
if (['.','e'].includes(tecla))
   event.preventDefault()
}
</script>
<!--Script para el correcto funcionamiento del carro-->
    <script>
    function updateCartItem(obj,id){
        $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Fallo al actualizar, intentelo nuevamente.');
            }
        });
    }
    </script>
</head>
<body>
    <?php if(isset($_SESSION["usuario"])){?>
<div class="container">
    <div class="row content">
    <img src="../img/pizza.png" id="img-toys">
    <h1>Carrito Toys</h1>
    
    <table class="table col-lg-12 col-6">
    <thead>
        <tr>
            <th>Productos</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th> </th>
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
            <td><input id="numero" type="number" min="1" max="8" onkeypress="comprueba(this), comprueba2(this)" pattern="^[0-9]+" onkeydown="filtro()" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')"></td>
            <td><?php echo '$'.$item["subtotal"].' MX'; ?></td>
            <td>
                <a href="cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')"><i class='bx bxs-trash'></i></a>
            </td>
        </tr>
        <?php } }else{ ?>
        <tr><td colspan="5"><p>Tu carrito está vacío...</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td><a href="../views/menu-pizza.php" class="btn btn-warning"><i class='bx bx-chevron-left'></i> ¡Continuar comprando!</a></td>
            <td colspan="2"></td>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Total <?php echo '$'.$cart->total().' MX'; ?></strong></td>
            
            <?php 
              echo "<td><a href='checkout.php' class='btn btn-success'>Confirmar pedido<i class='bx bx-chevron-right'></i></a></td>";
            }
            ?>     
        </tr>
    </tfoot>
    </table>
</div>
</div>
    <?php }else { ?>
        <div class="text-center">
            <row>
        <img src="../img/pizza.png" style="width:30%;" class="col-lg-12 col-12"/>
        <h1>Parece que te has perdido un poco...</h1>
        <h3>Primero tienes que</h3>
        <a href="../index.php" class="btn btn-danger col-lg-4 col-4 ">¡Registrarte y/o Iniciar sesión!</a>
        <br><br><br>
        <h4>¡Para así continuar con la experiencia Toys!</h4>
        </row>
        </div>
        <?php $cart->destroy();
         } ?>
         <br> <br> <br>
</div>
</body>
</html>