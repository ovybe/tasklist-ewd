<?php
include 'connect.php';
session_start();
$user=$_POST['user_p'];
$pass=$_POST['pass_p'];
$email=$_POST['email_p'];
$nameFind = 'SELECT name FROM users WHERE name ="'.$user.'"';
$nameCompare = mysqli_query($conn, $nameFind);
$result=array();
  if(mysqli_num_rows($nameCompare)>0){
  $_SESSION['userex']=1;
  header("Location: ../register.php");
  die();
}
else $_SESSION['userex']=0;
$sql='INSERT INTO `users`(`name`, `password`, `email`) VALUES ("'.$user.'","'.md5($pass).'","'.$email.'")';
//print_r($sql);
$query=mysqli_query($conn,$sql);
if (mysqli_query($conn, $sql)) {
    $_SESSION['reg']=1;
    $_SESSION['seen']=0;
    $result['error']='';
	}
	else {
		$result['error']="Registration failed.";
	}
header("Location: ../login.php");
die();
 ?>
