<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Empleados</title>
</head>
<body>
    <div class="container">
        <h1 align="Center">Empleados</h1>
        <?php
        include '../class/database.php';
        $conexion = new Database();
        $conexion->conectarDB();

        $consulta = "SELECT * from EMPLEADOS";
        $tabla = $conexion->seleccionar($consulta);

        echo "<table class = 'table table-hover'> 
        <thead class = 'table-dark'>
        <tr>
        <th> ID_EMPLEADO</th> <th> NOMBRE </th> <th> TELEFONO </th> <th> PUESTO </th>
        </tr>
        </thead>
        <tbody>";
        foreach ($tabla as $registro)
        {
            echo "<tr>";
            echo "<td> $registro->ID_EMP </td>";
            echo "<td> $registro->NOMBRE </td>";
            echo "<td> $registro->TELEFONO";
            echo "<td> $registro->PUESTO";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        ?>
    </div>
</body>
</html>