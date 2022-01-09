<?php
include 'connect.php';
session_start();
$user_id=$_POST['user_id'];
$team_id=$_POST['team_id'];
$sql='DELETE FROM `notifications` WHERE notif_user_to='.$user_id.' AND notif_id=1 AND notif_team_id='.$team_id;
$query=mysqli_query($conn,$sql);
$result=array();
if($query){
  $result['error']='';
}
else {
  $result['error']='An error has occured declining the invite';
  $result['sql']=$sql;
}
echo json_encode($result);


die();
?>
