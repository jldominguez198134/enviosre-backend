<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
header("Access-Control-Allow-Headers:*");

require 'dbh.inc.php';

if((isset($_POST['email']))&&(isset($_POST['pwd']))&&(isset($_POST['cuentaBancaria']))&&(isset($_POST['cuentaBancariaDestino']))&&(isset($_POST['telefonoReceptor']))&&(isset($_POST['cantidad']))){
    $email=$_POST['email'];
    $password=$_POST['pwd'];
    $cuentaBancaria=$_POST['cuentaBancaria'];
    $cuentaBancariaDestino=$_POST['cuentaBancariaDestino'];
    $telefonoReceptor=$_POST['telefonoReceptor'];
    $cantidad=$_POST['cantidad'];
    $lugarTransaccion="Madrid";
}else{
    header("HTTP/1.1 400 Bad Request");
}


//LUGAR TRANSACCION
// $user_ip = getenv('REMOTE_ADDR');
// $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
// $country = $geo["geoplugin_countryName"];
// $city = $geo["geoplugin_city"];
// $lugarTransaccion=$city;


//Aceptar transaccion
$sql="SELECT * FROM usuarios WHERE email=?";
$stmt=mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("HTTP/1.1 500 Internal Server Error");
exit();
} else{
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    if($row=mysqli_fetch_assoc($result)){
        $pwdCheck=password_verify($password, $row['passwrd']);
        if($pwdCheck==false){
            header("HTTP/1.1 401 Unauthorized");
            exit;
            
        } elseif($pwdCheck==true){
            
            $sql2="SELECT * FROM cuentas_bancarias WHERE email=? AND cuentaBancaria=?";
            
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql2)){
                header("HTTP/1.1 500 Internal Server Error");
            exit;
            
        }else{
            mysqli_stmt_bind_param($stmt, "ss", $email, $cuentaBancaria);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck=mysqli_stmt_num_rows($stmt);
            if ($resultCheck !=1){
                header("HTTP/1.1 409 Conflict");
                exit();
        }
        else{
            
            $sql="INSERT INTO transacciones_realizadas (cuentaBancariaDestino, lugarTransaccion, telefonoReceptor, email, cuentaBancaria, cantidad) VALUES (?,?,?,?,?,?)";
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            }else{

                mysqli_stmt_bind_param($stmt, "ssssss", $cuentaBancariaDestino, $lugarTransaccion, $telefonoReceptor, $email, $cuentaBancaria , $cantidad);
                mysqli_stmt_execute($stmt);
                $datos=array(
                    "email"=>$email,
                    "lugarTransaccion"=>$lugarTransaccion,
                    "telefonoReceptor"=>$telefonoReceptor,
                    "cuentaBancaria"=>$cuentaBancaria,
                    "cantidad"=>$cantidad
                    );
                
                $payload = json_encode($datos);
                echo $payload;
        }

        }
    }
    }
}
    
mysqli_stmt_close($stmt);
mysqli_close($conn);

}
