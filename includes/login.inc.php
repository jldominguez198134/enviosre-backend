<?php
session_start();
if(isset($_POST['login-submit'])){

    require 'dbh.inc.php';

    $emailuid=$_POST['user'];
    $password=$_POST['pwd'];

    if (empty($emailuid) || empty($emailuid) ){
        header("Location: ../index.php?error=emptyfields");
    }

    else{
        $sql="SELECT * FROM usuarios WHERE user_id=? OR email=?";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
        exit();
        } else{
            mysqli_stmt_bind_param($stmt, "ss", $emailuid, $emailuid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                $pwdCheck=password_verify($password, $row['passwrd']);
                if($pwdCheck==false){
                    header("Location: ../index.php?error=wrongpassword");
                    exit();
                } elseif($pwdCheck==true){
                    
                    $_SESSION["user_id"]=$row['user_id'];
                    header("Location: ../profile_page.php?login=success&".$_SESSION["user_id"]);
                    exit();
                }
            }else{
                header("Location: ../index.php?error=nouser_".$stmt);
            }
        }
    }

} else {
    header("Location: ../index.php");
}