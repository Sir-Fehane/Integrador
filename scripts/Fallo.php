<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Fallo</title>
</head>
<body>
<div class="container mt-5 d-flex justify-content-center">
  <div class="row">
    <div class="col-12">
      <div class="alert alert-danger">
        <i class='bx bxs-error-circle'></i>
          <strong>Parece que ocurrio un error. Por favor, intenta de nuevo.</strong><br>
          <p>Redirigiendo a la pagina principal...</p>
        <div class="d-flex justify-content-center">
          <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
    header("refresh:3 ; ../views/admin.php")
?>
 <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</body>
</html>