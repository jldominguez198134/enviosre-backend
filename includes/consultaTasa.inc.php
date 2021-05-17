<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
header("Access-Control-Allow-Headers:*");

require 'dbh.inc.php';

if((isset($_POST['email']))&&(isset($_POST['monedaOrigen']))&&(isset($_POST['monedaDestino']))&&(isset($_POST['cantidad']))&&(isset($_POST['monedaDestino']))){
    $email=$_POST['email'];
    $monedaOrigen=$_POST['monedaOrigen'];
    $monedaDestino=$_POST['monedaDestino'];
    $cantidad=$_POST['cantidad'];
    $ratio_cambio=50;
    $cantidadTransformada=$cantidad*$ratio_cambio;
    
    //HORA CONSULTA
    date_default_timezone_set('Europe/Madrid');
    $horaConsulta= date("Y/m/d H:i:s");
}else{
    header("HTTP/1.1 400 Bad Request");
}


//Aceptar transaccion
$sql="SELECT * FROM usuarios WHERE email=?";
$stmt=mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    
    header("HTTP/1.1 500 Internal Server Error");
exit();
} else{
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultCheck=mysqli_stmt_num_rows($stmt);
    if ($resultCheck !=1){
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }else{  
        $sql="INSERT INTO consultas_tasa_diaria (monedaOrigen,monedaDestino, horaConsulta, horaConsultaFinalizacion, cantidad,cantidadTransformada, email) VALUES (?,?,?,?,?,?,?)";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("HTTP/1.1 500 Internal Server Error");
            exit();
        }else{
            //HORA CONSULTA FINALIZACION
            $horaConsultaFinalizacion= date("Y/m/d H:i:s");
            mysqli_stmt_bind_param($stmt, "sssssss", $monedaOrigen,$monedaDestino, $horaConsulta, $horaConsultaFinalizacion, $cantidad ,$cantidadTransformada, $email);
            mysqli_stmt_execute($stmt);
            $datos=array(
                "email"=>$email,
                "monedaOrigen"=>$monedaOrigen,
                "monedaDestino"=>$monedaDestino,
                "horaConsulta"=>$horaConsulta,
                "horaConsultaFinalizacion"=>$horaConsultaFinalizacion,
                "cantidad"=>$cantidad,
                "cantidadTransformada"=>$cantidadTransformada
                );
            
            $payload = json_encode($datos);
            echo $payload;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }
}



