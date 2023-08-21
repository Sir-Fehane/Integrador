<?php
session_start();
if(!isset($_SESSION['rol']))
{
  header('Location: ../index.php');
}
else
 {
  if ($_SESSION["rol"] == 2) {
    header("Location: ../index.php");
    exit;
  } elseif ($_SESSION["rol"] == 3) { 
    header("Location: puntoventa.php");
    exit;
  }
 }
 include "../class/database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
  h2
  {
    margin: auto;
    text-align: center;
  }
  .select-wrapper {
  margin-right: 10px;
}
</style>
<title>Administracion</title>
</head>
<body>
<div class="container-fluid justify-content-center">
  <div class="row">
    <nav class="navbar navbar-light bg-light">
      <div class="col-1 col-lg-1">
        <img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top">
      </div>
      <div class="col-lg-4 offset-lg-3 d-none d-lg-block justify-content-center">
        <h4>Reportes de Administración</h4>
      </div>
      <div class="col-5 col-lg-4 d-flex justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a type="button" class="btn btn-sm btn-primary" href="../scripts/cerrarSesion.php">
              Cerrar sesión
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
<div class="container-fluid">
<div class="btn-group d-flex" role="group" style="overflow-x: auto; white-space: nowrap; width: 100%;">
    <a class="btn btn-primary flex-fill" href="Inventario.php">Inventario</a>
    <a class="btn btn-primary flex-fill" href="Ordenes.php">Órdenes</a>
    <a class="btn btn-primary flex-fill" href="Productos.php">Productos</a>
    <a class="btn btn-primary flex-fill" href="Sucursales.php">Sucursales</a>
    <a class="btn btn-primary flex-fill" href="Personal.php">Personal</a>
    <a class="btn btn-primary flex-fill" href="Solicitudes.php">Solicitudes</a>
    <a class="btn btn-primary flex-fill" href="Ingresos.php">Ingresos</a>
    <a class="btn btn-primary flex-fill" href="ReporCierre.php">Cierres</a>
    <a class="btn btn-primary flex-fill" href="Movimientos.php">Movimientos en inv</a>
    <a class="btn btn-primary flex-fill" href="Merma.php">Merma</a>
</div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="non" role="tabpanel" tabindex="0">
      <br><br>
      <h3 align="center">Selecciona una pestaña en la sección de arriba.</h3>
      <br>
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-5">
            <?php
                    $db = new Database();
                    $db->conectarDB();
                    $consulta = "WITH ProductosVendidosPorSucursal AS (
                      SELECT
                          S.NOMBRE AS 'Sucursal',
                          P.NOMBRE AS 'Producto',
                          SUM(DO.CANTIDAD) AS 'Vendidas',
                          ROW_NUMBER() OVER(PARTITION BY S.ID_SUC ORDER BY SUM(DO.CANTIDAD) DESC) AS RowNum
                      FROM
                          SUCURSALES S
                      INNER JOIN
                          ORDEN_VENTA OV ON S.ID_SUC = OV.SUCURSAL AND OV.ESTADO = 'ENTREGADA'
                      INNER JOIN
                          DETALLE_ORDEN DO ON OV.NO_ORDEN = DO.NO_ORDEN
                      INNER JOIN
                          PRODUCTOS P ON DO.PRODUCTO = P.CODIGO
                      WHERE
                          OV.HORA_FECHA >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND OV.HORA_FECHA < CURDATE() -- Filtrar una semana
                      GROUP BY
                          S.ID_SUC,
                          P.NOMBRE
                  )
                  SELECT
                      PV.Sucursal,
                      PV.Producto,
                      PV.Vendidas
                  FROM ProductosVendidosPorSucursal PV
                  WHERE
                      PV.RowNum = 1;";
                    $reg = $db->seleccionar($consulta);
                    ?>
                    <table class="table table-hover">
                      <thead class="table-primary" align="center">
                        <tr>
                          <th colspan="3">
                          Pizza más vendida en la última semana
                          </th>
                        </tr>
                        <tr>
                          <th>Sucursal</th>
                          <th>Producto</th>
                          <th>Vendidas</th>
                        </tr>
                      </thead>
                      <tbody align='center'>
                        <?php
                        foreach ($reg as $row) 
                        {
                          echo "<tr>";
                          echo"<td>$row->Sucursal</td>";
                          echo"<td>$row->Producto</td>";
                          echo"<td>$row->Vendidas</td>";
                          echo "</tr>";
                        }
                        $db->desconectarDB();
                        ?>
                      </tbody>
                    </table>
          </div>
          <div class="col-12 col-lg-5 offset-1">
            <?php
                    $db = new Database();
                    $db->conectarDB();
                    $consulta = "SELECT COUNT(*) AS 'CONTADOR' FROM USUARIOS WHERE ROL = '2' AND ESTADO = 'ACTIVADO'";
                    $reg = $db->seleccionar($consulta);
                    ?>
                    <table class="table table-hover">
                      <thead class="table-primary" align="center">
                        <tr>
                          <th>
                            Número de clientes registrados
                          </th>
                        </tr>
                      </thead>
                      <tbody align='center'>
                        <?php
                        foreach ($reg as $row) 
                        {
                          echo"<td>$row->CONTADOR</td>";
                        }
                        $db->desconectarDB();
                        ?>
                      </tbody>
                    </table>
          </div>
          <div class="col-12 col-lg-5 offset-lg-2">
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>