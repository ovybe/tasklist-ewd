<?php
session_start();
include 'connect.php';
$email_mail=$_POST['email'];
$result=array();
$sql='SELECT user_id,name,email FROM `users` WHERE `email` LIKE "'.$email_mail.'"';
$query=mysqli_query($conn,$sql);
//echo $sql;
if (mysqli_num_rows($query)>0) {
    $result['row']=mysqli_fetch_row($query);
    $result['query']=$sql;
	}
	else {
		$result['error']="Could not fetch user info";
    $result['task_id']=0;
	}
  echo json_encode($result);
 ?>
