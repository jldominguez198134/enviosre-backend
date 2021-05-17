<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
header("Access-Control-Allow-Headers:*");

session_start();
if(isset($_POST['pwd'])){

    require 'dbh.inc.php';

    $email=$_POST['email'];
    $password=$_POST['pwd'];

    if (empty($email) ){
        // header("Location: ../index.php?error=emptyfields");
        header("HTTP/1.1 401 Unauthorized");
    }

    else{
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
                    // header("Location: ../profile_page.php");
                    //header("HTTP/1.1 200 OK");
                    $datos=array(
                            "email"=>$row['email'],
                            "nombre"=>$row['nombre'],
                            "apellidos"=>$row['telefono'], 
                            );
                    header("Content-Type: application/json");  
                    echo json_encode($datos);
                    exit;
                }
            }else{
                header("HTTP/1.1 401 Unauthorized");
                    exit;
            }
        }
    }

} else {
    header("HTTP/1.1 401 Unauthorized");
}