<?php
include 'connect.php';
$data_id=$_POST['team_id'];
$sql = 'DELETE FROM `teams` WHERE t_id='.$data_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['errordel1']='';
    $sql = 'DELETE FROM `t_relations` WHERE team_id='.$data_id;
    if(mysqli_query($conn,$sql)){
      $result['errordel2']='';
    }
    else {
      $result['errordel2']='Could not delete relations';
    }
	}
	else {
		$result['errordel1']="Could not delete id";
	}
  echo json_encode($result);
?>
