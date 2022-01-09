<?php
include 'connect.php';
$user_id=$_POST['user_id'];
$sql = 'SELECT * FROM `tasks` WHERE user_id='.$user_id;
$result=array();
$json=mysqli_query($conn, $sql);

if ($json) {
    $result=mysqli_fetch_all($json,MYSQLI_ASSOC);
    //$result['error']='';
    //echo json_encode($json);
	}
	else {
		$result['error']="Could not get tasks in the calendar.";
    $result['sql']=$sql;
    //echo json_encode($result);
	}
  echo json_encode($result);
 ?>
