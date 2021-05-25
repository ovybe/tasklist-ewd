<?php
include 'connect.php';
$task_status=$_POST['task_status'];
$data_id=$_POST['data_id'];
$condition = implode(', ', $data_id);
$sql = 'UPDATE `tasks` SET `task_status`='.$task_status.' WHERE task_id IN '.'('.$condition.')';
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
	}
	else {
		$result['error']="Could not insert result";
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
