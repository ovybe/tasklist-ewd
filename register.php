<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link rel="stylesheet" href="css/registerstyle.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<h3></h3>
<?php
session_start();
if(array_key_exists('userex',$_SESSION)){
  if($_SESSION['userex']==1)
  echo "<p>Error! Username already exists!</p>";
}
?>
<div class="formz">
<form id="register" method="POST" action="php/registerform.php">
  <div class="tooltip">
  <label for="user">Username: </label>
  <input id="user" name="user_p" type="text"/>
  <span id="userer" class="tooltiptext">Username has to have 3 or more characters</span>
</div>
<div class="tooltip">
  <label for="password">Password: </label>
  <input id="pass" name="pass_p" type="password"/>
  <span id="passer" class="tooltiptextp">Password has to have 6 or more characters</span>
</div>
<div class="emailtip">
  <label for="email">Email: </label>
  <input id="email" name="email_p" type="email"/>
</div>
<div class="others">
  <input id="subb" name="subm" type="submit" value="Submit"/>
  <p>Already have an account? <a href="login.php">Click here to go log in!</a></p>
</div>
</form>
</div>
<script>
$( "#register" ).submit(function( event ) {
var user=$('#user').val();
var pass=$('#pass').val();
var email=$('#email').val();
if(user.length>2){
  if(pass.length>5){
    return;
  }
  else $(".tooltiptextp").css("display","inline-block");
}
else $(".tooltiptext").css("display","inline-block");
event.preventDefault();
});
$("#user").focus(function() {
  if($(".tooltiptext").css("display")=="block")
  $(".tooltiptext").fadeOut();
});
$("#pass").focus(function() {
  if($(".tooltiptextp").css("display")=="block")
  $(".tooltiptextp").fadeOut();
});
</script>
</body>
</html>
