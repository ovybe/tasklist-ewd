<?php
include 'connect.php';
$user_id=$_POST['user_id'];
$sql= 'SELECT DISTINCT team_id FROM `t_relations` WHERE user_id='.$user_id;
$json=mysqli_query($conn,$sql);
$teams=array();

if($json){
if(mysqli_num_rows($json)>0){
    while($row=mysqli_fetch_row($json)){
      array_push($teams,$row[0]);
    }
    for($i=0;$i<count($teams);$i++){
      $sql2='SELECT * FROM `teams` WHERE t_id='.$teams[$i];
      $json2=mysqli_query($conn,$sql2);
      if($json2){
      $row=mysqli_fetch_assoc($json2);
      $result[$i]=$row;
      }
      else {
        $result[$i]="error";
      }
    }

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
