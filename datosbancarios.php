<?php
    session_start();
    require 'config/config.php';
    $configs = include('config/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Datos Bancarios</title>

</head>
<body>

<main>
<div>
    <h1 style="margin-left: 0px;">Login</h1>
    <div style="margin-top: 0px"> 
    <form id="form" action="includes/datosbancarios.inc.php" method="post">
    <input type="text" name="cuentaBancaria", placeholder="cuenta bancaria">
    <input type="text" name="pais", placeholder="pais">
    <input type="text" name="banco", placeholder="banco">
    <button type="submit" name="login-submit">Añadir Cuenta Bancaria</button>
    </form>

    </div>
    

</div>
    

</main>

</body>
</html>