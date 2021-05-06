<?php
    require 'config/config.php';
    $configs = include('config/config.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login</title>

</head>
<body>

<main>
<div>
    
    <h1 style="margin-left: 0px;">Login</h1>
    <?php
    if(isset($_GET['error'])){

        if($_GET['error']=='emptyfields'){
            echo '<p> Fill in all the fields!</p>';
        }
    }

    ?>


    <div style="margin-top: 0px"> 
    <form id="form" action="includes/login.inc.php" method="post">
    <input type="text" name="user", placeholder="username or email">
    <input type="password" name="pwd", placeholder="password">
    <button type="submit" name="login-submit">Login</button>
    </form>

    </div>
    

</div>
    

</main>

</body>
</html>