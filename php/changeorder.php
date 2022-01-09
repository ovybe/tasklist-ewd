<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include 'connect.php';
$task_id1=$_POST['task_id1'];
$task_id2=$_POST['task_id2'];
$order1=$_POST['task_id1'];
$order2=$_POST['task_id1'];

$sql = 'UPDATE `tasks` SET `order_id`='.$order2.' WHERE task_id='.$task_id1;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
    $sql2 = 'UPDATE `tasks` SET `order_id`='.$order1.' WHERE task_id='.$task_id2;
    if (mysqli_query($conn, $sql)) {
        $result['error2']='';
    	}
    	else {
    		$result['error2']="Could not update result";
        $result['sql2']=$sql;
    	}
	}
	else {
		$result['error']="Could not update result";
    $result['sql']=$sql;
	}

  echo json_encode($result);
 ?>
