<?php
$headermore=<<< EOT
<link href="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler_material.css" rel="stylesheet" type="text/css" charset="utf-8">
// <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
EOT;
include 'header.php';
require_once('php/connect.php');
$CURRENT_TEAM=$_GET['id'];
$sqltocheck="SELECT * FROM `t_relations` WHERE user_id=".$user_id." AND team_id=".$CURRENT_TEAM;
$result=mysqli_query($conn,$sqltocheck);
if(!mysqli_num_rows($result)>0){
  header('Location: myteams.php');
  exit;
}
else{
  $okadmin=0;
  while($row=mysqli_fetch_assoc($result))
    if($row['role']=='admin'){
      $okadmin=1;
    }
}
$sql="SELECT * FROM `teams` WHERE t_id=".$CURRENT_TEAM;
$query=mysqli_query($conn,$sql);

if($query){
  $result=mysqli_fetch_assoc($query);
  $CURRENT_TEAM_NAME=$result['t_name'];
}
$_SESSION['team_id']=$CURRENT_TEAM;

include 'notif.php';
?>
</div>
<div class="breadcrumbs">
  <a class="lnk" href="./mytasks.php">Home</a><a class="ina">></a><a class="lnk" href="./myteams.php">My Teams</a><a class="ina">></a><a class="ina"><?php echo ("Team ".$CURRENT_TEAM_NAME."'s Calendar") ?></a>
</div>
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

<script>
const CURRENT_TEAM=<?php echo $CURRENT_TEAM;?>;
const okadmin=<?php echo $okadmin;?>;
</script>
<script> var id = CURRENT_TEAM </script>

<?php
$footermore= <<< EOT
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.js"></script>
<script src="js/team_calendar.js"></script>
EOT;

?>


<?php
include 'footer.php';
?>
</div>
