<?php
include 'connect.php';
$category_name=$_POST['category_name'];
$category_id=$_POST['category_id'];
$sql = 'UPDATE `categories` SET `category_name`="'.$category_name.'" WHERE category_id='.$category_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $result['error']='';
	}
	else {
		$result['error']="Could not insert result";
	}
  echo json_encode($result);
 ?>
