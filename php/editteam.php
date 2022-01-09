<?php
include 'connect.php';
$team_id=$_POST['team_id'];
$team_name=$_POST['team_name'];
$team_color=$_POST['team_color'];
$sql = 'UPDATE `teams` SET `t_name`="'.$team_name.'",`t_color`="'.$team_color.'" WHERE t_id='.$team_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
    $result['sql']=$sql;
	}
	else {
		$result['error']="Could not edit team.";
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
