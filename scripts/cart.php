<?php
session_start();

if (isset($_POST['ID'])) {
  $id = $_POST['ID'];
  $titulo = $_POST['titulo'];
  $precio = $_POST['precio'];
  $cantidad = $_POST['cantidad'];
  $tamaño = $_POST['tamaño'];

  // Resto del código para agregar el producto al carrito
  $producto = array(
    "ID" => $id,
    "titulo" => $titulo,
    "precio" => $precio,
    "cantidad" => $cantidad,
    "tamaño" => $tamaño
  );

  if (isset($_SESSION['carrito'])) {
    $carrito_mio = $_SESSION['carrito'];
  } else {
    $carrito_mio = array();
  }

  $carrito_mio[] = $producto;
  $_SESSION['carrito'] = $carrito_mio;
}

// Redireccionar al index.php después de agregar el producto al carrito
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>
