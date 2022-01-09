<?php
session_start();
include 'connect.php';
$task_string=$_POST['task_string'];
$datetime=$_POST['datetime'];
$start_date=$datetime[0];
$end_date=$datetime[1];
$task_id=$_POST['task_id'];
$result=array();
$sql='UPDATE `tasks` SET `task_string`="'.$task_string.'",`task_start_date`="'.$start_date.'",`task_end_date`="'.$end_date.'" WHERE task_id='.$task_id;
$query=mysqli_query($conn,$sql);
//echo $sql;
if ($query) {
    $result['error']='';
    $result['start_date']=$start_date;
    $result['end_date']=$end_date;
    $result['query']=$sql;
	}
	else {
		$result['error']="Could not edit task";
    $result['task_id']=0;
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
