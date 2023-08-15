<?php
if(!isset($_REQUEST['id'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Toy's Pizza</title>
    <link rel="stylesheet" href="../css/carro.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <style>p{color:#2A52D5;}h1{color:#2A52D5;}</style>
</head>
<body>
<div class="container" style="text-align:center;">
    <h1>Estatus de la orden</h1>
    <p>Tu orden se realizo correctamente, tu orden es la #<?php echo $_GET['id']; ?></p>
    <?php include"../Mail/CORREO.php"?>
    <p>Se le ha enviado informacion de su orden en su correo, favor de checar su correo.</p>
    <br>
    <img src="../img/pizza.png" id="img-toys">
    <?php unset($_SESSION['TOTAL']); header("refresh:5 ; ../index.php")?>

</div>
</body>
</html>