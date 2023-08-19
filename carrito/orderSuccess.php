<?php
if(!isset($_REQUEST['id'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Toy's Pizza</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <style>h1,h3,h4,h5{color:#FECB00; text-shadow: -0.8px -0.8px 0 #000, 0.8px -0.8px 0 #000, -0.8px 0.8px 0 #000, 0.8px 0.8px 0 #000;}body{color:var(--text-color);background-image: url(../img/fondocar.jpg);background-repeat: repeat;background-size: auto;}</style>
  <link rel="stylesheet" href="../css/carro.css">
</head>
<body>
<div class="container" style="text-align:center;">
    <h1 class="mt-3">Estatus de la orden</h1>
    <br>
    <h3>Tu orden se realizó correctamente, tu orden es la #<?php echo $_GET['id']; ?></h3><br>
    <?php include "../Mail/CORREO.php"?>
    <h4>Se le ha enviado información de su orden a su correo, favor de checarlo para estar al pendiente, también, puede ver el estado de su orden </h4>
    <br>
    <h5>¡Gracias por su compra</h5><br>
    <a href="../index.php" class="btn btn-warning">¡Volver al inicio!</a><br><br>
    <img src="../img/pizza.png" id="img-toys">
    <?php unset($_SESSION['TOTAL']);?>

</div>
</body>
</html>