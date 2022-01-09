<?php
include 'connect.php';
$team_id=$_POST['team_id'];
$sql= 'SELECT * FROM `users` u INNER JOIN `t_relations` t ON u.user_id=t.user_id WHERE role="user" and team_id='.$team_id;
$json=mysqli_query($conn,$sql);

if($json){
if(mysqli_num_rows($json)>0){
    $result=mysqli_fetch_all($json);
}
else {
  $result['empty']='true';
}

}
else {
  $result['error']='There has been an error with the query';
  $result['sql']=$sql;
  //$result=mysqli_fetch_all($json);
}
echo json_encode($result);
?>
