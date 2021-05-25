<?php
session_start();
include 'connect.php';
$task_string=$_POST['task_string'];
$category_id=$_POST['category_id'];
$user_id=$_SESSION['user_id'];
$result=array();
$sql='INSERT INTO `tasks`(`task_string`, `category_id`,`user_id`) VALUES ("'.$task_string.'",'.$category_id.','.$user_id.')';
$query=mysqli_query($conn,$sql);
//echo $sql;
if ($query) {
    $result['task_id']=mysqli_insert_id($conn);
    $result['error']='';
	}
	else {
		$result['error']="Could not insert result";
    $result['task_id']=0;
	}
  echo json_encode($result);
 ?>
