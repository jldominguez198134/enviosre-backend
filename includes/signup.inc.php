<?php
require '../config/config.php';

$configs = include('../config/config.php');
$RECAPTCHA_V3_SECRET_KEY_var=$configs['captchaGoogle']['RECAPTCHA_V3_SECRET_KEY'];


require 'dbh.inc.php';
$token = $_POST['token'];
$action = $_POST['action'];


if(isset($_POST['pwd-repeat'])){
    //El usuario debe llegar a través de la página de signup
    echo $password;
        
    $nombre=$_POST['nombre'];
    $apellidos=$_POST['apellidos'];
    $username=$_POST['uid'];
    $email=$_POST['email'];
    $telefono=$_POST['telefono'];
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

        $sql="SELECT user_id  FROM usuarios WHERE user_id=?";
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

                $sql="INSERT INTO usuarios (user_id, email, passwrd, nombre, apellidos, telefono) VALUES (?,?,?,?,?,?)";
                $stmt=mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../signup.php?error=sqlerror");
                exit();
                }else{

                    mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $hashedPwd, $nombre, $apellidos, $telefono);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?signup=success");

                }

            }

        }

    }


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
    ?>