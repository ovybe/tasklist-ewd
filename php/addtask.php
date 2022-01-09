<?php
session_start();
include 'connect.php';
$task_string=$_POST['task_string'];
$order=$_POST['order'];
$category_id=0;
$datetime=$_POST['datetime'];
$start_date=$datetime[0];
$end_date=$datetime[1];
$user_id=$_POST['user_id'];
$result=array();
$sql='INSERT INTO `tasks`(`task_string`, `category_id`,`user_id`,`task_start_date`,`task_end_date`,`task_order`) VALUES ("'.$task_string.'",'.$category_id.','.$user_id.',"'.$start_date.'","'.$end_date.'",'.$order.')';
$query=mysqli_query($conn,$sql);
//echo $sql;
if ($query) {
    $result['task_id']=mysqli_insert_id($conn);
    $result['error']='';
    $result['start_date']=$start_date;
    $result['end_date']=$end_date;
    $result['query']=$sql;
	}
	else {
		$result['error']="Could not insert result";
    $result['task_id']=0;
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
