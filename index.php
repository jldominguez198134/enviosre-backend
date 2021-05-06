<?php
session_start();
require "header.php";
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>EnviosRe</title>

    <style>
    body{
    width: 1000px;
    margin: auto;
    margin-top: 20px
}
    section {
  display: flex;
  height: 60px;
    }
    article {
      flex:1;
    }

    .center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  opacity: 0.6;
    }  
    </style>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

</head>

<body>
<main>

<div> 

    <div>
        
    <?php

    if(isset($_SESSION['user_id'])){
        /*<p>Your are logged in!</p>*/
        echo '
        <br><br><br><br>
        BUENOS DÍAS '.$_SESSION['user_id'].', estás en tu sesión';
        
    } else{
        echo '
       <br><br><br><br>
        Envia tus remesas fácil y rápido con RE <br> <br> <br> <br>
        ';
        echo '<img class="center" width="1000px" height="682px" src="img/background_image.jpg">';
    }
            
    ?>

    </div>

</div>
    
</main>

</body>

</html>
