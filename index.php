<!-- GET LISTS BY STATUS -->
<?php
$headermore=<<< EOT
<link rel="stylesheet" type="text/css" href="css/lists.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
EOT;
include 'header.php';

$user_id=$_SESSION['user_id'];
require_once('php/connect.php');

$sql="SELECT * FROM `t_relations` WHERE user_id=".$user_id;
//echo $sql;
$result=mysqli_query($conn,$sql);
if($result && mysqli_num_rows($result)>0){
  $teamres=mysqli_fetch_all($result);
  $i=0;
  foreach ($teamres as $teamres) {
    $i++;
    $TEAMS_ID_ARR[$i]=$teamres['2'];
    $sql2="SELECT `t_color` FROM `teams` WHERE t_id=".$teamres['2'];
    //print_r($sql2);
    $result2=mysqli_query($conn,$sql2);
    $teamcol=mysqli_fetch_assoc($result2);
    $TEAMS_COLOR_ARR[$teamres['2']]=$teamcol['t_color'];
  }
  // not sure yet what to do here
}
else{
//header('Location: myteams.php');
//exit;
  }
  function add_months($months, DateTime $dateObject)
      {
          $next = new DateTime($dateObject->format('Y-m-d H:m:s'));
          $next->modify('last day of +'.$months.' month');

          if($dateObject->format('d') > $next->format('d')) {
              return $dateObject->diff($next);
          } else {
              return new DateInterval('P'.$months.'M');
          }
      }

  function endCycle($d1, $months)
      {
          $date = new DateTime($d1);

          // call second function to add the months
          $newDate = $date->add(add_months($months, $date));

          // goes back 1 day from date, remove if you want same day of month
          $newDate->sub(new DateInterval('P1D'));

          //formats final date to Y-m-d form
          $dateReturned = $newDate->format('Y-m-d H:m:s');

          return $dateReturned;
      }
function getTableForWeek($listStatus){
    $notif_datetime_week_end=date('Y-m-d H:m:s', strtotime('+1 week'));
    //$notif_datetime_week_now=date('Y-m-d H:m:s', time());
    global $conn,$CURRENT_TEAM,$CURRENT_TEAM_COLOR,$TEAMS_ID_ARR,$TEAMS_COLOR_ARR;
    if($CURRENT_TEAM_COLOR==null){
      $CURRENT_TEAM_COLOR='#FFFFFF';
    }
    $listArr=['To do','In progress','Done'];
    $html = FALSE;
    $sql = 'SELECT * FROM `tasks` WHERE task_end_date<="'.$notif_datetime_week_end.'" AND `task_status` = '.$listStatus.' AND `user_id` IN ('.implode(',',$TEAMS_ID_ARR).') ORDER BY `task_order` ASC ';
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable">';
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $tempid=$row['user_id'];
        $tempcol=$TEAMS_COLOR_ARR[$tempid];
        if($tempcol==null){
          $tempcol='#FFFFFF';
        }
        $html .= '<li style="background-color:'.$tempcol.'" data-task="'.$row['task_id'].'" data-before="'.$row['task_start_date'].'" data-after="'.$row['task_end_date'].'" class="ui-state-disabled"><span class="task-text">'.$row['task_string'].'</span></li>';
      }
      $html .= '</ul></div>';
    }
    else {
      $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable empty"></ul></div>';
    }
    return $html;
}
function getTableForMonth($listStatus){
    $task_end_date_now=date('Y-m-d H:m:s', time());
    $nMonths=1;
    $final=endCycle($task_end_date_now,$nMonths);
    global $conn,$CURRENT_TEAM,$CURRENT_TEAM_COLOR,$TEAMS_ID_ARR,$TEAMS_COLOR_ARR;
    if($CURRENT_TEAM_COLOR==null){
      $CURRENT_TEAM_COLOR='#FFFFFF';
    }
    $listArr=['To do','In progress','Done'];
    $html = FALSE;
    $sql = 'SELECT * FROM `tasks` WHERE task_end_date<="'.$final.'" AND `task_status` = '.$listStatus.' AND `user_id` IN ('.implode(',',$TEAMS_ID_ARR).') ORDER BY `task_order` ASC ';
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable">';
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $tempid=$row['user_id'];
        $tempcol=$TEAMS_COLOR_ARR[$tempid];
        if($tempcol==null){
          $tempcol='#FFFFFF';
        }
        $html .= '<li style="background-color:'.$tempcol.'" data-task="'.$row['task_id'].'" data-before="'.$row['task_start_date'].'" data-after="'.$row['task_end_date'].'" class="ui-state-disabled"><span class="task-text">'.$row['task_string'].'</span></li>';
      }
      $html .= '</ul></div>';
    }
    else {
      $html = '<div class="listdiv"><label for="sortable"'.($listStatus+1).'>'.$listArr[$listStatus].'</label><ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable empty"></ul></div>';
    }
    return $html;
}
?>

<?php
include 'notif.php';
?>
</div>
<div class="breadcrumbs">
  <a class="lnk">Home</a>
</div>
<div class="texts">
<p id="weekp"> This week's tasks</p>
</div>

<div class="lists">
<?php
for($i=0; $i<=2; $i++){
    $sortable = getTableForWeek($i);
    if($sortable != FALSE)
        echo $sortable;
}
?>
</div>
<p id="monthp"> This month's tasks</p>
<div class="listsmonth">
<?php
for($i=0; $i<=2; $i++){
    $sortable = getTableForMonth($i);
    if($sortable != FALSE)
        echo $sortable;
}
?>
</div>

<?php
$footermore= <<< EOT
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="js/index.js"></script>
EOT;
include 'footer.php';
?>
