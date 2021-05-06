<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    .menu{
  font-size: 14px;
  color: #005C1D;
  margin-left: 7px;
  text-decoration: none;
  font-weight:bold
  
}

.menu:hover{
color: black;
text-decoration: underline;
font-weight:bold;
}
        
        
    .menufirst{
  font-size: 14px;
  margin-left: 0px;
  color: #005C1D;
  text-decoration: none;
  font-weight:bold
  
}

    .menufirst:hover{
    color: black;
    text-decoration: underline;
    font-weight:bold;
    }
    .resizedTextbox {width: 100px; height: 10px;font-size: 12px}

    </style>

</head>
<body>

<header>

<header>

   <section>
  <article>
  
<a href="index.php">
    <img src="img/logo.jpg" alt="logo" height="100%" width="auto">
</a>
  
  </article>

    
    <?php
    
    if(isset($_SESSION['user_id'])){

        echo '<div class= "menu_login">
        <form action="includes/logout.inc.php" method="post">
        <button type="submit" name="logout-submit">Logout</button>
        </form>
        </div>';
        
        
    } else{
        
        
        echo ' </article>
        <div style="margin-top: 13px">
          <form action="login.php" method="post">
          <button style="font-size: 12px; height:18px;" type="submit" name="login-submit">Login</button>
          </form>
          </div>
          <a style="margin-left: 15px; margin-top: 13px; font-size: 14px" href="signup.php">Signup</a>
          ';

    }
        
?>

</section>


</header>

    
</body>
</html>