<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
header("Access-Control-Allow-Headers:*");

session_start();

require '../config/config.php';
$configs = include('../config/config.php');
require 'dbh.inc.php';


if(isset($_POST['email'])&&isset($_POST['pwd'])&&(isset($_POST['pwd_repeat']))){
    //El usuario debe llegar a través de la página de signup
        
    $nombre=$_POST['nombre'];
    $apellidos=$_POST['apellidos'];
    $email=$_POST['email'];
    $telefono=$_POST['telefono'];
    $password=$_POST['pwd'];
    $password_repeat=$_POST['pwd_repeat'];
}else{
    header("HTTP/1.1 400 Bad Request");
        exit();
}

if (empty($email) || empty($password) || empty($password_repeat)){

    header("HTTP/1.1 400 Bad Request");
    exit();

}

elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("HTTP/1.1 400 Bad Request");
    exit();
}

elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("HTTP/1.1 400 Bad Request");
    exit();
}

elseif($password!==$password_repeat){
    header("HTTP/1.1 400 Bad Request");
    exit();
}
else{

    $sql="SELECT email  FROM usuarios WHERE email=?";
    $stmt=mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("HTTP/1.1 500 Internal Server Error");
    exit();
    } else{

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $resultCheck=mysqli_stmt_num_rows($stmt);
        if ($resultCheck >0){
            header("HTTP/1.1 409 Conflict");
            exit();
        }
        else{

            $hashedPwd=password_hash($password, PASSWORD_DEFAULT);

            $sql="INSERT INTO usuarios (email, passwrd, nombre, apellidos, telefono) VALUES (?,?,?,?,?)";
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            }else{

                mysqli_stmt_bind_param($stmt, "sssss", $email, $hashedPwd, $nombre, $apellidos, $telefono);
                mysqli_stmt_execute($stmt);
                $datos=array(
                    "email"=>$email,
                    "nombre"=>$nombre,
                    "apellidos"=>$apellidos,
                    "telefono"=>$telefono
                    );
                
                $payload = json_encode($datos);
                echo $payload;
                // header("Location: ../datosbancarios.php?login=success");
            }

        }

    }

}


    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    ?>