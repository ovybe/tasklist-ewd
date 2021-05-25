<?php
include 'connect.php';
$task_string=$_POST['task_string'];
$data_id=$_POST['data_id'];
$sql = 'UPDATE `tasks` SET `task_string`="'.$task_string.'" WHERE task_id='.$data_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
	}
	else {
		$result['error']="Could not insert result";
	}
  echo json_encode($result);
 ?>
