<!-- GET LISTS BY STATUS -->
<?php
$headermore=<<< EOT
<link rel="stylesheet" type="text/css" href="css/lists.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
EOT;
include 'header.php';
require_once('php/connect.php');
if(isset($_GET['id'])){
$CURRENT_TEAM=$_GET['id'];
$sqltocheck="SELECT * FROM `t_relations` WHERE user_id=".$user_id." AND team_id=".$CURRENT_TEAM;
$result=mysqli_query($conn,$sqltocheck);
if(!mysqli_num_rows($result)>0){
  header('Location: myteams.php');
  exit;
}
$sql="SELECT * FROM `teams` WHERE t_id=".$CURRENT_TEAM;
//echo $sql;
$result=mysqli_query($conn,$sql);
if($result && mysqli_num_rows($result)>0){
  $teamres=mysqli_fetch_assoc($result);
  $CURRENT_TEAM_NAME=$teamres['t_name'];
  $CURRENT_TEAM_CREATOR=$teamres['t_creator_id'];
  $CURRENT_TEAM_COLOR=$teamres['t_color'];
  // not sure yet what to do here
}
else{
header('Location: myteams.php');
exit;
  }
}
function getTableFor($listStatus){
    global $conn,$CURRENT_TEAM,$CURRENT_TEAM_COLOR;
    if($CURRENT_TEAM_COLOR==null){
      $CURRENT_TEAM_COLOR='#FFFFFF';
    }
    $listArr=['To do','In progress','Done'];
    $html = FALSE;
    $sql = "SELECT * FROM `tasks` WHERE `task_status` = ".$listStatus." AND `user_id`=".$CURRENT_TEAM." ORDER BY `task_order` ASC ";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable">';
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $html .= '<li style="background-color:'.$CURRENT_TEAM_COLOR.'" data-task="'.$row['task_id'].'" data-before="'.$row['task_start_date'].'" data-after="'.$row['task_end_date'].'" class="ui-state-default"><span class="task-text">'.$row['task_string'].'</span><div class="toolbar"><button data-action="edit" class="toolbar_button"><i class="fas fa-edit"></i></button><button data-action="delete" class="toolbar_button"><i class="fas fa-minus"></i></button></div></li>';
      }
      $html .= '</ul></div>';
    }
    else {
      $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable empty"></ul></div>';
    }
    return $html;
}
?>
<button id="taskAddButton"><i class="fas fa-plus"></i> Add Task</button>
<?php
if($user_id==$CURRENT_TEAM_CREATOR){
  ?>
<button id="teamEditbutt"><i class="fas fa-user-edit"></i> Edit Team</button>
<?php }?>
<button id="invitemenu"><i class="fas fa-user-plus"></i> Invite Users</button>

<?php
include 'notif.php';
?>
</div>
<div class="breadcrumbs">
  <a class="lnk" href="./index.php">Home</a><a class="ina">></a><a class="lnk" href="./myteams.php">My Teams</a><a class="ina">></a><a class="ina"><?php echo $CURRENT_TEAM_NAME ?></a>
</div>
<table class='border_table'>
  <thead>
    <tr>
      <th id="bordertablemember" style="background-color:<?php echo $CURRENT_TEAM_COLOR;?>; color:black;" width="80%" align="left"><i class="fas fa-user-friends"></i> Member</th>
      <th id="bordertablehead2" style="background-color:<?php echo $CURRENT_TEAM_COLOR;?>"></th>
    </tr>
  </thead>
  <tbody>
    <!-- <tr>
      <td>Echipa</td>
      <td>
        <div data-id="1" class="toolbar">
        <div class='toolbar_button'>Invite User</div>
        <div class='toolbar_button'>Edit</div>
        <div class='toolbar_button'>Delete</div>
      </div>
      </td>
    </tr> -->
    <?php
    $sql= 'SELECT * FROM `users` u INNER JOIN `t_relations` t ON u.user_id=t.user_id WHERE team_id='.$CURRENT_TEAM.' AND u.user_id!='.$user_id;
    //echo $sql;
    $result= mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
      while($row=mysqli_fetch_assoc($result)){ ?>
        <tr>
          <td class='nameu'><?=$row['name']?></td>
          <td>
            <div data-id="<?=$row['user_id']?>" class="toolbar">
              <?php
              $sql='SELECT role FROM `t_relations` WHERE user_id='.$user_id.' AND team_id='.$CURRENT_TEAM;
              $result2=mysqli_query($conn,$sql);
              $rowcheck=mysqli_fetch_assoc($result2);
              //var_dump($rowcheck);
              if($rowcheck['role']=='admin'){?>
            <div data-action='delete' class='table_button'>Delete</div>
            <?php
            }
          ?>
          </div>
          </td>
        </tr>
         <?php
      }
    }
    else
      echo '<tr><td id="emptask">No users other than you found.</td><td></td></tr>';
       ?>
  </tbody>
</table>

<!-- Task ADD button + modal -->

<div id="myModalt" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span id="closet" class="close">&times;</span>

    <form class="taskform" action="javascript:;" method="post">
      <label for="tname">Task Name:</label>
      <input id="taskAddInput" name="t_name" type="text"/>
      <br>
      <label for datetimes>Select Schedule</label>
      <input type="text" name="datetimes" id="Datepick1"/>
     <!-- User list -->
      <button id="savebutt">Add</button>
    </form>
  </div>
</div>
<?php
if($user_id==$CURRENT_TEAM_CREATOR){
?>

<div id="myModalTED" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="closeTED">&times;</span>

    <form class="teamform" data-id="<?php echo $CURRENT_TEAM;?>" action="javascript:;"  method="post">
      <label for="tename">Team Name:</label>
      <input id="tename" name="te_name" type="text" value="<?php echo $CURRENT_TEAM_NAME;?>"/>
     <!-- User list -->
     <label for="teamcolor">Color</label>
      <input id="tecolor" name="teamcolor" type="color"></input>
      <button id="#savebutt">Save</button>
    </form>

  </div>
<?php
}
?>

  </div>
<div id="myModalEd" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span id="closeEd" class="close">&times;</span>

    <form class="edittaskform" action="javascript:;" method="post">
      <label for="tname">Task Name:</label>
      <input id="taskEditInput" name="t_name" type="text"/>
      <br>
      <label for="datetimesedit">Select Schedule</label>
      <input type="text" name="datetimesedit" id="DatepickEd"/>
     <!-- User list -->
      <button id="savebutt">Edit</button>
    </form>
  </div>
</div>

<!-- INVITE USERS -->

<div id="myModali" class="modal">
  <!-- User invite Modal content -->
  <div class="modali-content">
    <span class="closei">&times;</span>

    <form class="emailform" action="javascript:;" method="post">
     <!-- User list -->
        <div class="emailtip">
          <label for="email">Email to invite: </label>
          <input id="email" name="email_p" type="text"/>
          <button class="buton" onclick="add_email(this)">Add</button>
          <table id="eTable">
            <thead>
              <tr>
                <th>Email</th>
                <th>Username</th>
              </tr>
            </thead>
            <tbody>
          </tbody>
          </table>
        </div>
      <button onclick="send_invite(this)" id="#inviteb">Invite Users</button>
    </form>

  </div>

  </div>


<div class="lists">
<?php
for($i=0; $i<=2; $i++){
    $sortable = getTableFor($i);
    if($sortable != FALSE)
        echo $sortable;
}
?>
</div>

<script>const CURRENT_TEAM=<?php echo $CURRENT_TEAM?>;
const CURRENT_TEAM_COLOR='<?php echo $CURRENT_TEAM_COLOR?>';
</script>
<?php
$footermore= <<< EOT
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="js/team_page.js"></script>
EOT;
include 'footer.php';
?>
