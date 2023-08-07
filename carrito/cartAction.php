<?php
// initialize shopping cart class
include 'Cart.php';
$cart = new Cart;

// include database configuration file
include 'dbConfig.php';
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        // get product details
        $query = $db->query("SELECT * FROM PRODUCTOS WHERE CODIGO = ".$productID);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id' => $row['CODIGO'],
            'name' => $row['NOMBRE'],
            'price' => $row['PRECIO'],
            'qty' => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'viewCart.php':'index.php';
        header("Location: ".$redirectLoc);
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: viewCart.php");
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){
        // insert order details into database
        $insertOrder = $db->query("INSERT INTO ORDEN_VENTA (NO_ORDEN, USUARIO, TIPO, TOTAL, FORMA_PAGO, SUCURSAL) VALUES ('','".$_SESSION['sessCustomerID']."','LLEVAR','".$cart->total()."','EFECTIVO','".$_SESSION['IDSUCURSAL']."')");
        
        if($insertOrder){
            $orderID = $db->insert_id;
            $sql = '';
            $db->query("INSERT INTO NOTIFICACIONES (ID_NOT, ID_SUC, NUM_ORDEN, ESTADO) VALUES ('', '".$_SESSION['IDSUCURSAL']."','".$orderID."', 'PENDIENTE')" );
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
                $sql .= "INSERT INTO DETALLE_ORDEN (NO_ORDEN,PRODUCTO, CANTIDAD, NOTAS, ESTADO) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."', '', 'PENDIENTE');";
            }
            // insert order items into database
            $insertOrderItems = $db->multi_query($sql);
            
            if($insertOrderItems){
                $cart->destroy();
                header("Location: orderSuccess.php?id=$orderID");
            }else{
                header("Location: checkout.php");
            }
        }else{
            header("Location: checkout.php");
        }
    }else{
        header("Location: ../views/menu-pizza.php");
    }
}else{
    header("Location: ../views/menu-pizza.php");
}