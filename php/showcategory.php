<?php
session_start();
include 'connect.php';
$category_id=$_POST['category_id'];
$result=array();
$sql= 'SELECT task_id FROM `tasks` WHERE category_id ='.$category_id;
$query=mysqli_query($conn,$sql);
//echo $sql;
if ($query) {
    $result['error']='';
    $result['ids']=mysqli_fetch_all($query);
    // aici are toate chestiile
	}
	else {
		$result['error']="Could not insert result";
    $result['sql']=$sql;
	}
  echo json_encode($result);
 ?>
