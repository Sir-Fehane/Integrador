<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Login Cliente</title>
</head>
<body>
<div class="container">
        <?php
        include '../class/database.php';
        $db = new Database();
        $db->conectarDB();

        extract($_POST);

        $db->verifica("$usuario","$password");
        $db->desconectarDB();

        $db->desconectarDB();
        
        ?>
    </div>
</body>
</html>