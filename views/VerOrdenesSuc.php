<?php extract($_POST);
include"../class/database.php";
$db=New Database();
$db->conectarDB();
$idk=$_POST['idk'];

    $detallord=$db->seleccionar("SELECT PRODUCTOS.NOMBRE, PRODUCTOS.TAMANO,DETALLE_ORDEN.CANTIDAD
    FROM PRODUCTOS 
    INNER JOIN DETALLE_ORDEN ON DETALLE_ORDEN.PRODUCTO = PRODUCTOS.CODIGO
    INNER JOIN ORDEN_VENTA ON ORDEN_VENTA.NO_ORDEN=DETALLE_ORDEN.NO_ORDEN
    WHERE DETALLE_ORDEN.NO_ORDEN=".$idk."");
    $datoscliente=$db->seleccionar("SELECT USUARIOS.NOMBRE, USUARIOS.TELEFONO, USUARIOS.TELEFONO FROM USUARIOS
    INNER JOIN ORDEN_VENTA ON ORDEN_VENTA.NO_ORDEN=".$idk."");
    foreach($datoscliente)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy's Pizza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>
<body>
    <div class="div col-lg-8 offset-lg-2">
<table class="table mt-5">
    <thead>
    <tr class="table-danger">
        <th>Nombre</th>
        <th>Tamaño</th>
        <th>Cantidad</th>
    </tr>
    </thead>
    <tbody>
        <?php 
        foreach($detallord as $x)
    {
     echo
     "<tr class='table-warning'><td>".$x->NOMBRE."</td>
     <td>".$x->TAMANO."</td>
     <td>".$x->CANTIDAD."</td><hr></tr>";
    }
    ?>   
</tbody>
</table>
<p>Orden: <?php echo$idk;?></p>
<p>Cliente</p>

<hr>
</div>
</body>
</html>