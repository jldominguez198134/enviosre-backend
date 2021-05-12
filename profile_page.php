<?php
session_start();
require "header.php";
?>

<!DOCTYPE html>

<html lang="en">
<script src="scripts.js" charset="UTF-8"></script>
<head>

    <meta charset="UTF-8">

    <title>EnviosRe</title>

    <style>
    body{
    width: 1000px;
    margin: auto;
    margin-top: 20px;
    font-size: 1.5rem;
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

    <p>Your are logged in!</p>
        
    <?php

        echo '
        <br><br><br><br>
        BUENOS DÍAS '.$_SESSION['email'].', estás en tu sesión';
  
        echo '<img class="center" width="1000px" height="682px" src="img/background_image.jpg">';
    
            
    ?>

    </div>

</div>
    
</main>

</body>

</html>
