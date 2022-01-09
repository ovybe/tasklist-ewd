<?php
include 'connect.php';
$data_id=$_POST['user_id'];
$team_id=$_POST['team_id'];
$sql = 'DELETE FROM `t_relations` WHERE user_id='.$data_id.' AND team_id='.$team_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
	}
	else {
		$result['error']="Could not remove user";
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
