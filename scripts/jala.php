<?php 
session_start();
include "../carrito/Cart.php";
$cart=new Cart();
$cart->destroy();
extract($_POST);
unset($_SESSION['SUCURSALCHIDA']);
$_SESSION['SUCURSALCHIDA']=$_POST["nombre"];
header("Location:../views/menu-pizza.php");
?>