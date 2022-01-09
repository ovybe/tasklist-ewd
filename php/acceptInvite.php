<?php
include 'connect.php';
session_start();
$user_id=$_POST['user_id'];
$team_id=$_POST['team_id'];
$sql='INSERT INTO `t_relations`(`user_id`,`role`,`team_id`) VALUES ("'.$user_id.'","user",'.$team_id.')';
$query=mysqli_query($conn,$sql);
$result=array();
if($query){
  $result['error']='';
  $sql='DELETE FROM `notifications` WHERE notif_user_to='.$user_id.' AND notif_id=1 AND notif_team_id='.$team_id;
  $query=mysqli_query($conn,$sql);
  if($query){
    $result['delete']='';
  }
  else {
    $result['delete']='error';
    $result['sql']=$sql;
  }
}
else {
  $result['error']='An error has occured accepting the invite';
  $result['sql']=$sql;
}
echo json_encode($result);


die();
?>
