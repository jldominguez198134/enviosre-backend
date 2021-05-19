<?php
require 'dbh.inc.php';
if(isset($_POST['email'])&&(isset($_POST['pwd']))){
$email=$_POST['email'];
$password=$_POST['pwd'];
} else {
    header("HTTP/1.1 400 Bad Request");
}

//AUTENTICACION
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
            $sql2="SELECT a.email, a.nombre, a.apellidos, a.telefono, b.cuentaBancaria FROM usuarios a LEFT JOIN cuentas_bancarias b ON a.email=b.email WHERE a.email=?";
            
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql2)){
                header("HTTP/1.1 500 Internal Server Error");
            exit;    
        }else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            $row=mysqli_fetch_assoc($result);
            // header("Location: ../profile_page.php");
            //header("HTTP/1.1 200 OK");
            $datos=array(
                    "email"=>$row['email'],
                    "nombre"=>$row['nombre'],
                    "apellidos"=>$row['apellidos'],
                    "telefono"=>$row['telefono'], 
                    "cuentaBancaria"=>$row['cuentaBancaria'], 
                    );
            header("Content-Type: application/json");  
            echo json_encode($datos);
            exit;
        }}
    }else{
        header("HTTP/1.1 401 Unauthorized");
            exit;
    }
}
