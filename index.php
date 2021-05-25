<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="css/look.css" type="text/css" media="screen" charset="utf-8">
  </head>
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/part.js"></script>
    <?php
    session_start();
    if(!array_key_exists('user_id',$_SESSION)){
      header("Location: login.php");
      die();
    }
    $user_id=$_SESSION['user_id'];
    $user=$_SESSION['name'];
    ?>
<nav id="menu">
      <ul class="menu">
      <li>
      <?=$user?>
      <i class="down"></i>
      <ul class="submenu">
        <li>
            <a href="php/logout.php">Log out</a>
        </li>
      </ul>
    </li>
    </ul>
    </nav>
    <div id="hdiv1" class="headerdiv">
      <div id="todolistdiv">
      <h2>Tasklist by Ovidiu Butiu</h2>
      <legend>Write the task you want to add in this input below and use the select box to choose a category</legend>
      <input type="text" id="myInput" placeholder="Example">
      <select id="myInputaddC" name="listacat">
        <option data-id="0">All</option>
        <?php
        include 'php/connect.php';
        $sql= 'SELECT * FROM `categories` WHERE user_id='.$user_id;
        $result= mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          while($row=mysqli_fetch_assoc($result)){ ?>
          <option data-id="<?=$row['category_id']?>" value="<?=$row['category_name']?>"><?=$row['category_name']?></option>
          <?php
          }
        }
           ?>
      </select>
      <div class="buton" onclick="addTask()">Add</div>
    </div>
    <div id="catdiv">
      <legend>Write the category you want to add in this input below</legend>
      <input type="text" id="myInputC" placeholder="Example">
      <div class="buton" onclick="addCategory()">Add Category</div>
      <br/>
      <h3>Display category</h3>
      <!-- <ul id="catul">
        <?php
        // DOESNT WORK FOR NOW, REASON UNKNOWN
        include 'php/connect.php';
        $sql= 'SELECT * FROM `categories` WHERE user_id='.$user_id;
        $result= mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          while($row=mysqli_fetch_assoc($result)){ ?>
          <li data-id="<?=$row['category_id']?>"><label><?=$row['category_name']?></label></li>
          <?php
          }
          echo "</ul>";
        }
        else {
          echo "</ul>";
        }
         ?> -->
         <select id="catul" name="listacat">
           <option data-id="0">All</option>
           <?php
           include 'php/connect.php';
           $sql= 'SELECT * FROM `categories` WHERE user_id='.$user_id;
           $result= mysqli_query($conn,$sql);
           if(mysqli_num_rows($result)>0){
             while($row=mysqli_fetch_assoc($result)){ ?>
             <option data-id="<?=$row['category_id']?>" value="<?=$row['category_name']?>"><?=$row['category_name']?></option>
             <?php
             }
           }
              ?>
         </select>
         <div class="buton" id="delcat" onClick="deleteCategory()">Delete Category</div>
         <div class="buton" id="editcat" onClick="editCategory()">Edit Category</div>
         <input id="editforcat" type="text"/>
    </div>
    <div id="uldiv">
      <h3>To do</h3>
      <div class="buton" onclick="SelectallToDo()">Select all</div>
      <div class="buton" onclick="moveToDone()">Move Selected To Done</div>
      <div id="delseltodo" class="buton" onclick="DeleteSelectedToDo()">Delete Selected</div>
      <select id="changecat" name="listacat">
        <option data-id="0">All</option>
        <?php
        include 'php/connect.php';
        $sql= 'SELECT * FROM `categories` WHERE user_id='.$user_id;
        $result= mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          while($row=mysqli_fetch_assoc($result)){ ?>
          <option data-id="<?=$row['category_id']?>" value="<?=$row['category_name']?>"><?=$row['category_name']?></option>
          <?php
          }
        }
           ?>
      </select>
      <div class="buton" onclick="changeCatToDo()">Change Category</div>
      <ul id="theul">
        <?php
        include 'php/connect.php';
        $sql='SELECT * FROM `tasks` WHERE `task_status`=0 AND user_id='.$user_id;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) { ?>
   <li class="listselected" data-id="<?=$row['task_id']?>"><input type="checkbox"> <label><?=$row['task_string']?></label><input type="text"><button class="editb" onclick="editTask(this)">Edit</button><button class="delb" onclick="deleteTask(this)">Delete</button></li>
<?php
  }
  echo '<h3 class="ifemptyt" style="display:none;">The list is empty.</h3>';
  echo "</ul>";
} else {
  echo '<h3 class="ifemptyt">The list is empty.</h3>';
  echo "</ul>";
}
         ?>
      <h3>Done</h3>
      <div class="buton" onclick="SelectallDone()">Select all</div>
      <div class="buton" onclick="moveToBack()">Move Selected Back</div>
      <div id="delseldone" class="buton" onclick="DeleteSelectedDone()">Delete Selected</div>
      <select id="changecatdone" name="listacat">
        <option data-id="0">All</option>
        <?php
        include 'php/connect.php';
        $sql= 'SELECT * FROM `categories` WHERE user_id='.$user_id;
        $result= mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
          while($row=mysqli_fetch_assoc($result)){ ?>
          <option data-id="<?=$row['category_id']?>" value="<?=$row['category_name']?>"><?=$row['category_name']?></option>
          <?php
          }
        }
           ?>
      </select>
      <div class="buton" onclick="changeCatDone()">Change Category</div>
      <ul id="doneul">
        <?php
        include 'php/connect.php';
        $sql='SELECT * FROM `tasks` WHERE `task_status`=1 AND user_id='.$user_id;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) { ?>
   <li class="listselected" data-id="<?=$row['task_id']?>"><input type="checkbox"><label><?=$row['task_string']?></label><input type="text"><button class="editb" onclick="editTask(this)">Edit</button><button class="delb" onclick="deleteTask(this)">Delete</button></li>
<?php
  }
  echo '<h3 class="ifemptyt" style="display:none;">The list is empty.</h3>';
  echo "</ul>";
} else {
  echo '<h3 class="ifemptyt">The list is empty.</h3>';
  echo "</ul>";
}
?>
    </div>
  </div>
  </body>
</html>
