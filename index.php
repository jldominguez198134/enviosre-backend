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
        
    <p>
       <br><br><br><br>
        Envia tus remesas fácil y rápido con RE <br> <br> <br> <br>
     </p>
        <img class="center" width="700px" height="auto" src="img/background_image.jpg">;

        <p>
       <br><br><br><br>
        ¿Quieres Contactarnos? <br> <br>
     
    <div style="margin-top: 0px"> 
    <form id="form" action="includes/contactar.inc.php" method="post">
    <input type="text" name="nombre_apellidos", placeholder="nombre y apellidos">
    <input type="text" name="email", placeholder="email">
    <input type="number" name="telefono", placeholder="telefono">
    <input type="text" name="comentario", placeholder="comentario">
    <button type="submit" name="contactar">Contactar</button>
    </form>
    
    </p>

    </div>

</div>
    
</main>

</body>

</html>
