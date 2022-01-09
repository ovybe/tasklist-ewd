<?php
include 'connect.php';
$data_id=$_POST['data_id'];
$team_id=$_GET['tid'];
$sql = 'DELETE FROM `t_relations` WHERE team_id='.$team_id.' AND user_id='.$data_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
	}
	else {
		$result['error']="Could not kick user";
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
