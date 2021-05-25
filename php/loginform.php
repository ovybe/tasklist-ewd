<?php
include 'connect.php';
session_start();
$user=$_POST['user_p'];
$pass=$_POST['pass_p'];
$sql='SELECT `user_id` FROM `users` WHERE name="'.$user.'" AND password="'.md5($pass).'"';
//print_r($sql);
$result=array();
$query=mysqli_query($conn,$sql);
if(mysqli_num_rows($query)==0){
  echo '<p>Error! There is something wrong with your username or password.</p>';
  $_SESSION['logerr']=1;
  header("Location: ../login.php");
}
else {
  $row=mysqli_fetch_assoc($query);
  $result['user_id']=$row['user_id'];
  //print_r($result);
  $_SESSION['user_id']=$result['user_id'];
  $_SESSION['name']=$user;
}
/*if (mysqli_num_rows($result)==0){
  echo '<p>Error! There is something wrong with your username or password.</p>';
}
else{
$_SESSION['user_id']=$result['user_id'];
}*/
header("Location: ../index.php");
die();
 ?>
