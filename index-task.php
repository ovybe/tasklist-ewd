<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="shortcut icon" href="#">
    <title>Task List</title>
    <link href="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler_material.css" rel="stylesheet" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="css/look.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  </head>
  <body>
    <?php
    session_start();
    if(!array_key_exists('user_id',$_SESSION)){
      header("Location: login.php");
      die();
    }
    $user_id=$_SESSION['team_id'];
    $user=$_SESSION['name'];
    ?>
    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:600px;'>
        <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
            <div class="dhx_cal_tab" name="day_tab"></div>
            <div class="dhx_cal_tab" name="week_tab"></div>
            <div class="dhx_cal_tab" name="month_tab"></div>
    </div>
    <div class="dhx_cal_header"></div>
    <div class="dhx_cal_data"></div>
  </div>
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
      <legend>Write the task you want to add in this input below, use the date picker and select box to choose a date and category.</legend>
      <input type="text" id="myInput" placeholder="Example">
      <span id="interactablein">
      <!-- <input type="datetime-local" id="startDate"> -->
      <!-- <input type="datetime-local" id="endDate"> -->
    </span>
    </div>
    <span id=butonforadd>
    <input type="text" name="datetimes" id="Datepick1"/>
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
  </span>
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
      <h3>Doing</h3>
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
    <script>
   const userId = '<?php echo $_SESSION["user_id"]; ?>'
   //console.log('The user id is', userId);
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.js"></script>
    <script src="js/part.js"></script>
  </body>
</html>
