<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://kit.fontawesome.com/81958b65b4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/notifmenu.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/topbar.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/sidebar.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/teammenu.css" type="text/css" media="screen" charset="utf-8">
    <?php
    if($headermore)
      echo $headermore;
    ?>
    <title></title>
  </head>
  <body>

    <?php
    session_start();
    if(!array_key_exists('user_id',$_SESSION)){
      header("Location: login.php");
      die();
    }
    $user_id=$_SESSION['user_id'];
    $user=$_SESSION['name'];
    //echo "<p>Welcome,  $user </p>"
    ?>
    <div class="bars">
    <div class="sidenav">
  <img src = "svgs/logo.svg" alt="Logo"/>
  <a href="./myteams.php"><i class="fas fa-users"></i> My Teams</a>
  <a href="./index.php"><i class="fas fa-list"></i> My Tasks</a>
    </div>
  </div>
    <div class="main">
      <div class="topnav" id="myTopnav">
        <script>
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
        </script>
<!-- REMINDER TO CLOSE THE DIV FOR TOPNAV -->
