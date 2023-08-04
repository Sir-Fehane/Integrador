<?php
session_start();

if (isset($_POST['index']) && is_numeric($_POST['index'])) {
    $index = intval($_POST['index']);

    // Verificar si el índice existe en el carrito
    if (isset($_SESSION['carrito'][$index])) {
        // Eliminar el ítem del carrito utilizando unset()
        unset($_SESSION['carrito'][$index]);

        // Reorganizar los índices para evitar huecos en el array
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
    $totalFinal=($_POST[$totalFinal]);
}

// Redireccionar a la página anterior después de eliminar el producto del carrito
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
