<?php
session_start();

include 'connect.php';
$notif_id=1;
$notif_user_to=array();
$notif_user_to=$_SESSION['user_to'];
$notif_user_from=$_SESSION['user_from'];
$notif_team_id=$_SESSION['t_id'];
$notif_datetime=date('m/d/Y h:i:s a', time());
$result=array();
for($i=0;$i<$notif_user_to.length();$i++){
  $sql='INSERT INTO `notifications`(`notif_id`, `notif_user_to`,`notif_user_from`,`notif_team_id`,`notif_datetime`) VALUES ('.$notif_id.','.$notif_user_to[$i].','.$notif_user_from.','.$notif_team_id.',"'.$notif_datetime.'")';
  $query=mysqli_query($conn,$sql);
    //echo $sql;
    if ($query) {
         $result[$i]='';
	   }
	   else
     {
		     $result[$i]="Could not insert result";
         $result['task_id']=0;
	    }
}
$result['query']=$sql;
  echo json_encode($result);
 ?>
