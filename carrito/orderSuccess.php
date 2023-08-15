<?php
if(!isset($_REQUEST['id'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Success - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <style>
    .container{width: 100%;padding: 50px;}
    p{color: #34a853;font-size: 18px;}
    </style>
</head>
</head>
<body>
<div class="container">
    <h1>Estatus de la orden</h1>
    <p>Tu orden se realizo correctamente, tu orden es la #<?php echo $_GET['id']; ?></p>
    <?php include"../Mail/CORREO.php"?>
    <p>Se le ha enviado informacion de su orden en su correo, favor de checar su correo.</p>
    
    <?php (header("refresh:3 ; ../index.php")) ?>
</div>
</body>
</html>