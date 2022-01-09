<?php
session_start();
include 'connect.php';
$email_mail=$_POST['email'];
$team_id=$_POST['team_id'];
$result=array();
$sql='SELECT user_id,name,email FROM `users` WHERE `email`="'.$email_mail.'"';
$query=mysqli_query($conn,$sql);
//echo $sql;
if (mysqli_num_rows($query)>0) {
    $result['row']=mysqli_fetch_row($query);
    $result['query']=$sql;
    $sql='SELECT * FROM `notifications` WHERE notif_id=1 AND notif_user_to='.$result['row']['0'].' AND notif_team_id='.$team_id;
    $query=mysqli_query($conn,$sql);
    if(mysqli_num_rows($query)>0){
      $result['error']='invexistent';
    }
    $sql='SELECT * FROM `t_relations` WHERE user_id='.$result['row']['0'].' AND team_id='.$team_id;
    $query=mysqli_query($conn,$sql);
    if(mysqli_num_rows($query)>0){
      $result['error']='useralreadyinteam';
    }
  }
	else {
		$result['error']="fetchinfoerror";
    $result['task_id']=0;
	}
  echo json_encode($result);
 ?>
