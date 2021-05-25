<?php
include 'connect.php';
$category_id=$_POST['category_id'];
$sql = 'DELETE FROM `categories` WHERE category_id='.$category_id;
$result=array();
if (mysqli_query($conn, $sql)) {
    $sql='UPDATE `tasks` SET `category_id`=0 WHERE category_id='.$category_id;
    if(mysqli_query($conn,$sql))
    {
      $result['error']='';
    }
    else $result['error']="Updating had an issue.";
	}
	else {
		$result['error']="Could not delete";
	}
  echo json_encode($result);
 ?>
