<?php
include 'connect.php';
$data_id=$_POST['data_id'];
$sql = 'DELETE FROM `tasks` WHERE task_id='.$data_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
	}
	else {
		$result['error']="Could not delete result";
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
