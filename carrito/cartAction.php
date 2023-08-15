<?php
// initialize shopping cart class
include 'Cart.php';
$cart = new Cart;

// include database configuration file
$server = "mysql:host=toys-pizzadb.crljnq1eyagb.us-east-1.rds.amazonaws.com; dbname=BDTOYS";
$user = "admin";
$password = "buenasnoches123,-";
try {
    $pdo = new PDO($server, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    ///$resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        // get product details
        $query = ("SELECT * FROM PRODUCTOS WHERE CODIGO = ".$productID);
        $statement=$pdo->prepare($query);
        $statement->execute();
        //solo funciona con fetch al parecer
        $row=$statement->fetch(PDO::FETCH_ASSOC);
        $itemData = array(
            'id' => $row['CODIGO'],
            'name' => $row['NOMBRE'],
            'price' => $row['PRECIO'],
            'qty' => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'viewCart.php':'../index.php';
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
       try 
{
    /*
        En primer lugar, deben prepararse TODAS las consultas
        antes de empezar la transacción.
        Esto no es ningún problema, porque las consultas no varían,
        varían los datos que se vinculan. Este es el precisamente
        el quid de la prevención contra Inyección SQL
    */
    $sqla="INSERT INTO ORDEN_VENTA (NO_ORDEN, USUARIO, TIPO, TOTAL, FORMA_PAGO, SUCURSAL, ESTADO) VALUES (:no_orden,:usuario,:tipo,:total,:forma_pago,:sucursal,:estado)";
    $stmtOrder = $pdo->prepare($sqla);
    
    $sqlb="INSERT INTO NOTIFICACIONES (ID_NOT, ID_SUC, NUM_ORDEN, ESTADO, FECHA) VALUES (:id_not,:id_suc,:num_orden,:estado, :fecha)";
    $stmtNotification = $pdo->prepare($sqlb);
    
    $sqlc="INSERT INTO DETALLE_ORDEN (NO_ORDEN,PRODUCTO, CANTIDAD, NOTAS) VALUES (:no_orden, :producto, :cantidad, :notas)";
    $stmtDetalle = $pdo->prepare($sqlc);
    
    /*
        Empezamos la transacción 
    */
        
    $pdo->beginTransaction();

    /*
        Variables para valores fijos 
        porque al vincular con bindParam no se pueden pasar valores a mano
    */
    $empty='';
    $tipo='LLEVAR';
    $forma_pago='EFECTIVO';
    $sucursal=sprintf('%s %s',$_SESSION['IDSUCURSAL'],date('Y-m-d'));
    $estado='PENDIENTE';
    $fechanotis=date('Y-m-d');
    
    /*
        Vinculación de datos de la primera consulta
    */
    $stmtOrder->bindParam(':no_orden',$empty,PDO::PARAM_STR);
    $stmtOrder->bindParam(':usuario',$_SESSION['sessCustomerID'],PDO::PARAM_STR);
    $stmtOrder->bindParam(':tipo',$tipo,PDO::PARAM_STR);
    $stmtOrder->bindParam(':total',$cart->total(),PDO::PARAM_STR);
    $stmtOrder->bindParam(':forma_pago',$forma_pago,PDO::PARAM_STR);
    $stmtOrder->bindParam(':sucursal',$sucursal,PDO::PARAM_STR);
    $stmtOrder->bindParam(':estado',$estado,PDO::PARAM_STR);
    $stmtOrder->execute();  
    $orderID = $pdo->lastInsertId();
       $_SESSION['orden']=$orderID;
    
    /*
        Con esto verificamos que hubo una inserción ...
        OJO: Para que esto funcione, la tabla debe tener una columna
        del tipo AUTO_INCREMENT 
    */ 
    if ($orderID > 0) 
    {
        /*
            Vinculación de datos para el INSERT
            de la tabla NOTIFICACIONES
        */
        $stmtNotification->bindParam(':id_not',$empty,PDO::PARAM_STR);
        $stmtNotification->bindParam(':id_suc',$_SESSION['IDSUCURSAL'],PDO::PARAM_STR);
        $stmtNotification->bindParam(':num_orden',$orderID,PDO::PARAM_STR);
        $stmtNotification->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmtNotification->bindParam(':fecha',$fechanotis,PDO::PARAM_STR);
        $stmtNotification->execute();   
        
        
        $cartItems = $cart->contents();
        foreach($cartItems as $item)
        {
            /*
                Vinculación de datos para el INSERT de la tabla DETALLE_ORDEN
                Dentro del bucle, sólo vinculamos cada dato 
                y ejecutamos la consulta
            */
            $stmtDetalle->bindParam(':no_orden',$orderID,PDO::PARAM_STR);
            $stmtDetalle->bindParam(':producto',$item['id'],PDO::PARAM_STR);
            $stmtDetalle->bindParam(':cantidad',$item['qty'],PDO::PARAM_STR);
            $stmtDetalle->bindParam(':notas',$empty,PDO::PARAM_STR);        
            $stmtDetalle->execute();                            
        }
        /*
            Aquí confirmamos la transacción de
            todas las consultas anteriores
        */
        $pdo->commit();

        $header=sprintf('Location: orderSuccess.php?id=%s',$orderID);
        $cart->destroy();       
    } else {
        /*
            No se insertó un LAST_ID, hacer el location que corresponda
        */      
        $header='Location: checkout.php?msg=No se insertó un LAST_ID';
    }
        
    header($header);        
    
}
catch(\PDOException $e)
{
    /*
        Si ocurre cualquier error aquí revertimos la consulta con rollBack 
        esto evitará inconsistencia en los datos.
        Aquí pondremos en el header un mensaje con lo obtenido en getMessage()
        aunque en producción conviene cambiarlo por un mensaje personalizado.
    */
    $pdo->rollBack();
        $header=sprintf('Location: checkout.php?msg=%s',$e->getMessage());
        header($header);
        
}
        //
    }else{
        header("Location: ../views/menu-pizza.php");
    }
}else{
    header("Location: ../views/menu-pizza.php");
}