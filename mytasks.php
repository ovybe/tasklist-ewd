<!-- GET LISTS BY STATUS -->
<?php
require_once('php/connect.php');

$sql="SELECT * FROM `t_relations` WHERE user_id=".$user_id;
echo $sql;
$result=mysqli_query($conn,$sql);
if($result && mysqli_num_rows($result)>0){
  $teamres=mysqli_fetch_all($result);
  for($i=0;$i<count($teamres);$i++){
    $TEAMS_ID_ARR[$i]=$teamres['team_id'];
    $sql2="SELECT `t_color` FROM `teams` WHERE t_id=".$teamres['team_id'];
    $result2=mysqli_query($conn,$sql);
    $teamcol=mysqli_fetch_assoc($result2);
    $TEAMS_COLOR_ARR[$i]=$teamcol['t_color'];
  }
  // not sure yet what to do here
}
else{
//header('Location: myteams.php');
//exit;
  }

function getTableFor($listStatus){
    global $conn,$CURRENT_TEAM,$CURRENT_TEAM_COLOR;
    if($CURRENT_TEAM_COLOR==null){
      $CURRENT_TEAM_COLOR='#FFFFFF';
    }
    $listArr=['To do','In progress','Done'];
    $html = FALSE;
    $sql = "SELECT * FROM `tasks` WHERE `task_status` = ".$listStatus." AND `user_id` IN (";
    for($i=0;$i<count($TEAMS_ID_ARR);$i++){
      $sql.$TEAMS_ID_ARR.",";
    }
    $sql.") ORDER BY `task_order` ASC ";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable">';
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $html .= '<li style="background-color:'.$CURRENT_TEAM_COLOR.'" data-task="'.$row['task_id'].'" data-before="'.$row['task_start_date'].'" data-after="'.$row['task_end_date'].'" class="ui-state-default"><span class="task-text">'.$row['task_string'].'</span><div class="toolbar"><button data-action="edit" class="toolbar_button">=</button><button data-action="delete" class="toolbar_button">X</button></div></li>';
      }
      $html .= '</ul></div>';
    }
    else {
      $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable empty"></ul></div>';
    }
    return $html;
}
$headermore=<<< EOT
<link rel="stylesheet" type="text/css" href="css/lists.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
EOT;
include 'header.php';
?>
<button id="taskAddButton">Add Task</button>
<button id="teamEditbutt">Edit</button>
<button id="invitemenu">Invite Users</button>

<?php
include 'notif.php';
?>
</div>
<div class="breadcrumbs">
  <a class="lnk" href="./mytasks.php">Home</a><a class="ina">></a><a class="lnk" href="./myteams.php">My Teams</a><a class="ina">></a><a class="ina"><?php echo $CURRENT_TEAM_NAME ?></a>
</div>


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
          <div class="buton" onclick="add_email(this)">Add</div>
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
