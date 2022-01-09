<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/createteamstyle.css" type="text/css" media="screen" charset="utf-8">
  </head>
  <body>
    <?php
    session_start();
    if(!array_key_exists('user_id',$_SESSION)){
      header("Location: login.php");
      die();
    }
    $user_id=$_SESSION['user_id'];
    ?>
    <ul>
    </ul>
    <script>
    const userId = '<?php echo $_SESSION["user_id"]; ?>';
    </script>
    <div class="headerm">
    <form id="create_team" method="POST" action="#" onsubmit="clicked(event)">
      <div class="tooltip">
      <label for="t_name">Team Name: </label>
      <input id="tName" name="t_name" type="text"/>
      <label for="t_color">Color: </label>
      <input id="tColor" name="t_color" type="color"/>
    </div>
    <div class="emailtip">
      <label for="email">Email to invite: </label>
      <input id="email" name="email_p" type="text"/>
      <button class="buton" onclick="add_email()">Add</button>
      <table id="eTable">
        <tbody>
        <tr>
          <th>Email</th>
          <th>Username</th>
        </tr>
      </tbody>
      </table>
    </div>
    <div class="others">
      <button id="subb" name="subm" type="submit" onclick="clicked(event)">Submit</button>
    </div>
    </form>
  </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="js/create-team.js"></script>
  </body>
</html>
