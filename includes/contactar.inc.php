<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
header("Access-Control-Allow-Headers:*");

require 'dbh.inc.php';

if(isset($_POST['email'])){
    //El usuario debe llegar a través de la página de comentario
    
    date_default_timezone_set('Europe/Madrid');
    $fechaMensaje=date("Y/m/d H:i:s");

    $nombre=$_POST['nombre_apellidos'];
    $email=$_POST['email'];
    $telefono=$_POST['telefono'];
    $comentario=$_POST['comentario'];

    $sql="INSERT INTO formularios (nombreApellido, correo, telefono, mensaje, fechaMensaje) VALUES (?, ?, ?, ?, ?)";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("HTTP/1.1 500 Internal Server Error");
        exit;
    }else{

        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $comentario, $fechaMensaje);
        mysqli_stmt_execute($stmt);
        header("HTTP/1.1 200 OK");
        exit;

    }
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

    ?>