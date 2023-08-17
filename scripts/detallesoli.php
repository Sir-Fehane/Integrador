<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header('Location: ../index.php');
    exit;
} else {
    if ($_SESSION["rol"] == 2) {
        header("Location: ../index.php");
        exit;
    } elseif ($_SESSION["rol"] == 1) { 
        header("Location: admin.php");
        exit;
    }
}
include '../class/database.php';
$conexion = new Database();
$conexion->conectarDB();
$solicitud_id = $_POST['idSolicitud'];
$insumo_id = $_POST['insumo'];

$insercion_query = "INSERT INTO DETALLE_SOLICITUD (SOLICITUD, INVENTARIO, CANTIDAD) VALUES (:solicitud_id, :insumo_id, 0)";

$params = array(
    ':solicitud_id' => $solicitud_id,
    ':insumo_id' => $insumo_id
);

$resultado = $conexion->execute($insercion_query, $params);

if ($resultado) {
    // Redireccionar a la página de éxito si la operación fue exitosa
    header("Location: Esoli.php");
    exit(); // Asegurarse de que el script termine aquí para evitar la ejecución posterior
} else {
    // Mostrar un mensaje de error si la operación falló
    echo "Error al agregar el insumo.";
}
?>