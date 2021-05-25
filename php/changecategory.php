<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include 'connect.php';
$category_id=$_POST['category_id'];
$data_id=$_POST['data_id'];
$condition = implode(', ', $data_id);

$sql = 'UPDATE `tasks` SET `category_id`='.$category_id.' WHERE task_id IN '.'('.$condition.')';
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
