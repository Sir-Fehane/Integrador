<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
 <style>
  #tabla
  {
    margin: auto;
  }
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
<div class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-expand navbar-expand-lg navbar-light bg-light">
      <div class="col-1 col-lg-1">
        <a class="navbar-brand"><img src="../img/pizza.png" alt="Logo" width="60" height="48" class="d-inline-block align-text-top"></a>
      </div>
      <div class="col-6 col-lg-5 offset-1 offset-lg-3 d-flex align-items-center">
        <form class="d-flex" action="" method="post">
          <?php
          include "../class/database.php";
          $db = new Database();
          $db->conectarDB();
          $cadena = "SELECT ID_SUC,NOMBRE FROM SUCURSALES";
          $reg = $db->seleccionar($cadena);

          echo "<div class='me-2'>
          <select name='sucursal' class='form-select'>
          <option value='0' selected>Seleccionar sucursal...</option>";
          foreach ($reg as $value)
          {
            echo "<option value='".$value->ID_SUC."'>".$value->NOMBRE."</option>";
          }
          echo "</select>
          </div>";
          $db->desconectarDB();
          ?>
          <button type="submit" class="btn btn-primary">Seleccionar</button>
        </form>
      </div>
      <div class="col-3 col-lg-1 offset-1">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cerrarses">Salir</button>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
<div class="d-flex align-items-start ">
  <div class="nav flex-column me-3 bg-light" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#inv" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Inventario</button>

    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#ing" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Ingresos</button>

    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#emp" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Personal</button>

  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <!--INVENTARIO-->
    <div class="tab-pane fade" id="inv" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
      <div class="container-fluid">
      <?php
        $db = New Database();
        $db->ConectarDB();
        if (isset($_POST['sucursal'])) 
        {
        $sucursalId = $_POST['sucursal'];
        if($sucursalId != 0)
        {
          $consulta = "SELECT NOMBRE FROM SUCURSALES WHERE ID_SUC = $sucursalId";
          $sucursal = $db->seleccionar($consulta);
          $Nombre = $sucursal[0]->NOMBRE;
          $consulta = "SELECT I.NOMBRE AS 'Nombre', CONCAT(INS.CANTIDAD,' ',I.PRESENTACION) AS 'Existencia',INS.FECHA AS 'Fecha'
          FROM INVENTARIO I
          INNER JOIN INV_SUC INS ON I.ID_INS = INS.INVENTARIO
          INNER JOIN SUCURSALES S ON INS.SUCURSAL = S.ID_SUC
          WHERE S.ID_SUC = $sucursalId;";
          $tabla = $db->seleccionar($consulta);
          echo "
        <h2>Sucursal $Nombre</h2>
        <table class='table table-hover' id='tabla'>
          <thead class='table-primary'>
          <tr>
          <th>Nombre</th>
          <th>Existencia</th>
          <th>Fecha de recepcion</th>
          </tr>
        </thead>
        <tbody>";
        
        foreach($tabla as $registro)
        {
            echo "<tr>";
            echo "<td> $registro->Nombre </td>";
            echo "<td> $registro->Existencia </td>";
            echo "<td> $registro->Fecha </td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        $db->desconectarDB();
        }
      }
      ?>
      </div>
      
    </div>
    <!--INGRESOS-->
    <div class="tab-pane fade" id="ing" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">...</div>
    <!--PERSONAL-->
    <div class="tab-pane fade" id="emp" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
    <div class="container">
        <h1 align="Center">Personal</h1>
        <?php
        $conexion = new Database();
        $conexion->conectarDB();

        $cadena = "SELECT ID_SUC, NOMBRE FROM SUCURSALES";
        $reg = $conexion->seleccionar($cadena);
        ?>
        <?php
        $sucursalSeleccionada = -1;
        if (isset($_POST['sucursal'])) {
        $sucursalSeleccionada = $_POST['sucursal'];
        }

        $consulta = "SELECT EMPLEADOS.NOMBRE, EMPLEADOS.PUESTO, EMPLEADOS.TELEFONO
        FROM EMPLEADOS
        INNER JOIN SUCURSALES ON EMPLEADOS.SUCURSAL = SUCURSALES.ID_SUC
        WHERE SUCURSALES.ID_SUC = $sucursalSeleccionada";

        $tabla = $conexion->seleccionar($consulta);

        if (!empty($tabla)) {
            echo "<table class = 'table table-hover'> 
            <thead class = 'table-primary'>
            <tr>
            <th> Nombre</th> <th> Puesto</th> <th> Teléfono</th>
            </tr>
            </thead>
            <tbody>";
            foreach ($tabla as $registro)
            {
                echo "<tr>";
                echo "<td> $registro->NOMBRE </td>";
                echo "<td> $registro->PUESTO </td>";
                echo "<td> $registro->TELEFONO </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else 
        {
            echo "Selecciona una sucursal";
        }
        ?>
    </div>
    </div>
  </div>
</div>
<!-- Cerrar Sesion -->
<div class="modal fade" id="cerrarses" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cerrar Sesion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estas seguro que deseas cerrar sesion?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="../index.php" role="button">Cerrar sesion</a>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>

</body>
</html>
