<?php
session_start();

require '../config/config.php';

$configs = include('../config/config.php');

require 'dbh.inc.php';

//Parametros Obligatorios
if(isset($_POST['cuentaBancaria'])&&(isset($_POST['email']))){
    //El usuario debe llegar a través de la página de signup
        
    $cuentaBancaria=$_POST['cuentaBancaria'];
    $email=$_POST['email'];
    //Parametros Opcionales
    $pais=$_POST['pais'];
    $banco=$_POST['banco'];
}
else{
    header("HTTP/1.1 400 Bad Request");
}



//Introducction datos
$sql="SELECT cuentaBancaria  FROM cuentas_bancarias WHERE cuentaBancaria=?";
$stmt=mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("HTTP/1.1 500 Internal Server Error");
exit();
} else{
    mysqli_stmt_bind_param($stmt, "s", $cuentaBancaria);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $resultCheck=mysqli_stmt_num_rows($stmt);
    if ($resultCheck >0){
        header("HTTP/1.1 409 Conflict");
        exit();
    }else{
$sql="INSERT INTO cuentas_bancarias (email, cuentaBancaria, pais, banco) VALUES (?,?,?,?)";
$stmt=mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}else{

    mysqli_stmt_bind_param($stmt, "ssss", $email, $cuentaBancaria, $pais, $banco);
    $resultexec=mysqli_stmt_execute($stmt);
    if ($resultexec===false){
        header("HTTP/1.1 400 Bad Request");
        exit();
    }else{
        $datos=array(
            "email"=>$email,
            "cuentaBancaria"=>$cuentaBancaria,
            "pais"=>$pais,
            "banco"=>$banco
            );
        
        $payload = json_encode($datos);
        echo $payload;

    }
}  
mysqli_stmt_close($stmt);
mysqli_close($conn);
    }
}

    ?>