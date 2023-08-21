<?php
session_start();
include '../class/database.php';
$conexion = new Database();
$conexion->conectarDB();

if (isset($_POST['x_button'])) {
    // Lógica para el botón "X"
    $productID = $_POST['x_button'];

    // Obtener el nombre del producto basado en el productID
    $productNameQuery = "SELECT P.NOMBRE FROM PRODUCTOS P INNER JOIN PROD_SUC PS ON PS.PRODUCTO = P.CODIGO WHERE PS.PS_ID = :productID";
    $productNameParams = array(
        ':productID' => $productID
    );
    $productNameResult = $conexion->selecsinall2($productNameQuery, $productNameParams);

    if ($productNameResult && isset($productNameResult['NOMBRE'])) {
        $productName = $productNameResult['NOMBRE'];

        // Actualizar el estado de todos los productos con el mismo nombre a "NO DISPONIBLE"
        $updateQuery = "UPDATE PROD_SUC SET ESTADO = 'NO DISPONIBLE' WHERE SUCURSAL = :idsuc AND PRODUCTO IN (
            SELECT CODIGO FROM PRODUCTOS WHERE NOMBRE = :nombre
        )";

        $params = array(
            ':idsuc' => $_SESSION['IDSUCUR'],
            ':nombre' => $productName
        );

        $resultado = $conexion->execute($updateQuery, $params);

        if ($resultado) {
            // Redirigir a la página de origen o mostrar un mensaje de éxito
            header("Location: ../views/disponibles.php");
            exit;
        } else {
            // Manejar el error si la consulta de actualización falla
            echo "Error al actualizar el estado de los productos.";
        }
    } else {
        // Manejar el error si no se puede obtener el nombre del producto
        echo "Error al obtener el nombre del producto.";
    }
} elseif (isset($_POST['check_button'])) {
    // Lógica para el botón "check"
    $productID = $_POST['check_button'];

    // Obtener el nombre del producto basado en el productID
    $productNameQuery = "SELECT P.NOMBRE FROM PRODUCTOS P INNER JOIN PROD_SUC PS ON PS.PRODUCTO = P.CODIGO WHERE PS.PS_ID = :productID";
    $productNameParams = array(
        ':productID' => $productID
    );
    $productNameResult = $conexion->selecsinall2($productNameQuery, $productNameParams);

    if ($productNameResult && isset($productNameResult['NOMBRE'])) {
        $productName = $productNameResult['NOMBRE'];

        // Actualizar el estado de todos los productos con el mismo nombre a "DISPONIBLE"
        $updateQuery = "UPDATE PROD_SUC SET ESTADO = 'DISPONIBLE' WHERE SUCURSAL = :idsuc AND PRODUCTO IN (
            SELECT CODIGO FROM PRODUCTOS WHERE NOMBRE = :nombre
        )";

        $params = array(
            ':idsuc' => $_SESSION['IDSUCUR'],
            ':nombre' => $productName
        );

        $resultado = $conexion->execute($updateQuery, $params);

        if ($resultado) {
            // Redirigir a la página de origen o mostrar un mensaje de éxito
            header("Location: ../views/disponibles.php");
            exit;
        } else {
            // Manejar el error si la consulta de actualización falla
            echo "Error al actualizar el estado de los productos.";
        }
    } else {
        // Manejar el error si no se puede obtener el nombre del producto
        echo "Error al obtener el nombre del producto.";
    }
}
