<?php
require '../config/config.php';

$configs = include('../config/config.php');
$RECAPTCHA_V3_SECRET_KEY_var=$configs['captchaGoogle']['RECAPTCHA_V3_SECRET_KEY'];


require 'dbh.inc.php';
$token = $_POST['token'];
$action = $_POST['action'];

 
// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $RECAPTCHA_V3_SECRET_KEY_var, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);
 
// verificar la respuesta
if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    
    // Si entra aqui, es un humano, puedes procesar el formulario
    //echo "ok!, eres un humano";
    if(isset($_POST['pwd-repeat'])){
        //User has to reach this page through subit form
        echo $password;
            
        $username=$_POST['uid'];
        $email=$_POST['email'];
        $password=$_POST['pwd'];
        $password_repeat=$_POST['pwd-repeat'];
    
        echo($username.$email);
    
        if (empty($username) || empty($email) || empty($password) || empty($password_repeat)){
    
            header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
            exit();
    
        }
    
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: ../signup.php?error=invalidmailuid");
            exit();
        }
    
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: ../signup.php?error=invalidmail&uid=".$username);
            exit();
        }
        elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: ../signup.php?error=invaliduid&mail=".$email);
            exit();
        }
    
        elseif($password!==$password_repeat){
            header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
            exit();
        }
        else{
    
            $sql="SELECT uidUsers FROM users WHERE uidUsers=?";
            $stmt=mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../signup.php?error=sqlerror");
            exit();
            } else{
    
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
    
                $resultCheck=mysqli_stmt_num_rows($stmt);
                if ($resultCheck >0){
                    header("Location: ../signup.php?error=usertaken&uid=".$username."&mail=".$email);
                exit();
                }
                else{
    
                    $hashedPwd=password_hash($password, PASSWORD_DEFAULT);
    
                    $sql="INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?,?,?)";
                    $stmt=mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../signup.php?error=sqlerror");
                    exit();
                    }else{
    
                        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?signup=success");
    
                    }
    
                }
    
            }
    
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
    }
} else {
    // Si entra aqui, es un robot....
	echo "Error, eres un robot";
}




