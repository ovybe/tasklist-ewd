<?php
session_start();
include 'connect.php';
$categoryname=$_POST['category_name'];
$user_id=$_SESSION['user_id'];
$sql='INSERT INTO `categories`(`category_name`,`user_id`) VALUES ("'.$categoryname.'",'.$user_id.')';
$result=array();
//echo $sql;
if (mysqli_query($conn, $sql)) {
    $result['category_id']=mysqli_insert_id($conn);
    $result['error']='';
	}
	else {
		$result['error']="Could not insert result";
    $result['category_id']=0;
	}
  echo json_encode($result);
 ?>
