<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Sign Up</title>

</head>
<body>

<main>
<div>
    
    <h1 style="margin-left: 0px;">Signup</h1>
    <?php
    if(isset($_GET['error'])){

        if($_GET['error']=='emptyfields'){
            echo '<p> Fill in all the fields!</p>';
        }
    }

    $user_ip = getenv('REMOTE_ADDR');
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip="));
    $country = $geo["geoplugin_countryName"];
    $city = $geo["geoplugin_city"];
    $json_string=json_encode($city, JSON_PRETTY_PRINT);

    echo "$json_string"

    ?>


    <div style="margin-top: 0px"> 
    <form id="form" action="includes/signup.inc.php" method="post">
    <input type="text" name="email", placeholder="email">
    <input type="text" name="nombre", placeholder="nombre">
    <input type="text" name="apellidos", placeholder="apellidos">
    <input type="number" name="telefono", placeholder="telefono">
    <input type="password" name="pwd", placeholder="password">
    <input type="password" name="pwd_repeat", placeholder="Repeat-password">
    <button type="submit" name="signup-submit">Signup</button>
    </form>

    </div>
    

</div>
    

</main>

</body>
</html>