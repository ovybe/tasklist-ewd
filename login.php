<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Page</title>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/loginstyle.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
  <div class="headerm">
  <?php
  session_start();
  if(array_key_exists('logout',$_GET))
  echo "<h3>Logged out successfully!</h3>";
  if(array_key_exists('reg',$_SESSION))
  if($_SESSION['reg'] && $_SESSION['seen']==0){
  echo "<h3>Registration successful! Try logging in!</h3>";
  $_SESSION['seen']=1;
}
if(array_key_exists('logerr',$_SESSION))
echo "<h3>Error! There is something wrong with your username or password.</h3>";
  ?>
<form class="login" method="POST" action="php/loginform.php">
  <label for="user">Username: </label>
  <input id="user" name="user_p" type="text"/>
  <label for="password">Password: </label>
  <input id="pass" name="pass_p" type="password"/>
  <input id="subl" name="" type="submit" value="Log in"/>
  <p>New here? <a href="register.php">Click here to register!</a></p>
</form>
</div>
</body>
</html>
